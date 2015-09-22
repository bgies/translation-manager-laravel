<?php

namespace Bgies\TranslationEditor;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository;
use Illuminate\View\Factory;
use Illuminate\Translation\Translator;
use App\Http\Controllers\Controller;
use App\User;

class TranslationEditorController extends Controller
{

    /**
     * Config repository.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $configRepository;

    /**
     * Illuminate view Factory.
     *
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * Illuminate translator class.
     *
     * @var \Illuminate\Translation\Translator
     */
    protected $translator;

    /**
     * Illuminate Filesystem class.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;
    
    
    /**
     * Supported Locales
     *
     * @var array
     */
    protected $supportedLocales;

    protected $defaultLanguage = false;

    public function __construct(Repository $configRepository, Factory $view,
        Translator $translator, Filesystem $filesystem)
    {
        $this->configRepository = $configRepository;
        $this->view = $view;
        $this->translator = $translator;
        $this->filesystem = $filesystem;
        
        $path = \Request::path();
        if (str_contains($path, 'transedit')) {
            if (! \Request::ajax() && ($path != 'transedit/dashboard')) {
                \Redirect::route('transedit.dashboard');
            }
        }
    }

    private function getDefaultFiles()
    {
        $defaultFolder = $this->getDefaultLanguageFolder();
    }

    private function getLanguageFile($locale, $page)
    {
        return $this->translator->getLoader()->load($locale, $page);
    }

    private function getLanguageFileList($locale)
    {
        return \File::files($this->getLanguageFolder() . $locale);
    }
    
    private function getLanguageFolder()
    {
        return base_path() . '/resources/lang/';
    }

    private function getLocaleFolder($locale) {
        return $this->getLanguageFolder() . $locale;
    }
    
    private function getDefaultLanguageFolder()
    {
        return $this->getLanguageFolder() . '/' . $this->getDefaultLanguage();
    }

    private function getAllLanguageFolders()
    {
        return \File::directories($this->getLanguageFolder());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function dashboard()
    {
        $defaultLocale = \App::getLocale();
        $defaultFiles = $this->getLanguageFileList($defaultLocale);
        foreach ($defaultFiles as $index => $defaultFile) {
            $defaultFiles[$index] = \File::name($defaultFile);
        }
        
        // get the default language file (the first file with the default language
        $language1 = $this->getLanguageFile($defaultLocale, $defaultFiles[0]);
        
        $allLanguages = $this->filesystem->getRequire(__DIR__ . '/AllLanguages.php');
        
        $enabledLanguages = $this->getAllLanguageFolders();
        $enabledLangs = array('' => '');
        foreach($enabledLanguages as $index => $lang) {
            $explodedPath = explode('/', $lang);
            $thisLocale = end($explodedPath);
            $enabledLangs[$thisLocale] = $allLanguages[$thisLocale]['name'];
        }
        
        return view('translationeditor::dashboard')->with('default_files', $defaultFiles)
            ->with('enabled_langs', $enabledLangs)
            ->with('language1', $language1)
            ->with('language2', array())
            ->with('all_languages', $allLanguages)
            ->with('default_files', $defaultFiles)
            ->with('default_locale', $defaultLocale)
            ->with('locale1',  $defaultLocale)
            ->with('locale2',  '')
            ->with('activePage', 'dashboard');
    }

    public function getLanguagePage($locale1, $locale2, $page)
    {
        if ($locale2 == 'none') {
            $locale2 = '';
        }
        $language1 = $this->getLanguageFile($locale1, $page);
        $language2 = [];
        if ($locale2 != '') {
            $language2 = $this->getLanguageFile($locale2, $page);
        }
        $bothLanguages = [];
        foreach ($language1 as $index => $single) {
            $isArray1 = is_array($single);
            $l2 = '';
            $isArray2 = false;
            if (array_key_exists($index, $language2)) {
                $l2 = $language2[$index];    
                $isArray2 = is_array($l2);
            }
            
            $bothLanguages[$index] = ['is_array1'  => $isArray1, 'language1' => $single,
                                  'is_array2'  => $isArray2, 'language2' => $l2];
        }
        
//        $allLanguages = $this->filesystem->getRequire(__DIR__ . '/AllLanguages.php');
        
        return View('translationeditor::language')
            ->with('both_languages', $bothLanguages)
            ->with('language1', $language1)
            ->with('language2', $language2)
            ->with('locale1', $locale1 )
            ->with('locale2', $locale2);

    }

    public function getOnlinePage()
    {
        $defaultLang = $this->getDefaultLanguage();
        
        return View('translationeditor::online');
    }
    
    /** 
     * checks to see if it can find the key value. Used to find  
     * 
     * @param string $key
     * @param string $value
     * 
     * returns bool
     */
    private function replaceKeyValue($filePath, $key, $oldVal, $newVal) {
    }

    
    public function writeArraytoFile($locale, $theFile, $key, $oldVal, $newVal)
    {
        $localeFolder = $this->getLocaleFolder($locale);
        $filePath = $localeFolder . '/' . $theFile . '.php';
        
        $replaced = false;
        $file = fopen($filePath, "rb");
        if ($file) {
            $entireFile = '';
            while (($line = fgets($file)) !== false) {
                if (strpos($line, $key, 1)) {
                    // rebuild the line
                    $newLine = substr($line, 0, strpos($line, '=>') + 2) . " '" . $newVal . "'";
                    // if the old line has a comma at the end, put it in this line also
                    if (strripos(rtrim($line), ',') > strlen(rtrim($line)) - 2) {
                        $newLine .= ',';
                    }
                    $entireFile .= $newLine . PHP_EOL;
                    $replaced = true;
                } else {
                    $entireFile .= $line;
                }
            }
        
            fclose($file); // Close the file.
        
            if ($replaced) {
                $file = fopen($filePath, "w");
                fwrite($file,$entireFile);
                fclose($file);
                return true;
            }
        }
        return false;
    }

    public function saveChange() {
        $input = \Input::all();
        $pageName = $input['page'];
        $arrayField = $input['fieldname'];
        // break the array field into locale and fieldname. I suppose a fieldname
        // could include a dsah so just use substrings... I know my dash will be the 
        // first or only dash
        $locale = substr($arrayField, 0, strpos($arrayField, '-'));
        $fieldName = substr($arrayField, strpos($arrayField, '-')+ 1);
        $saveStr = $input['str'];
        $originalStr = $input['oldStr'];

        if ($this->writeArraytoFile($locale, $pageName, $fieldName, $originalStr, $saveStr)) {
            $data = array('success' => true, 'message' => 'Updated successfully');
        } else {
            $data = array('success' => false, 'message' => 'Unable to Update');
        }
        
        
        return json_encode($data);
    }
    
    
    /**
     * Return an array of all supported Locales
     *
     * @return array
     */
    public function getSupportedLocales()
    {
        if (! empty($this->supportedLocales)) {
            return $this->supportedLocales;
        }
        
        $locales = $this->configRepository->get('transedit::supportedLocales');
        
        $this->supportedLocales = $locales;
        
        return $locales;
    }
}