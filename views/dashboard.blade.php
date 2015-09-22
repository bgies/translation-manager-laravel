@extends((Request::ajax())?'translationeditor::blanklayout':'translationeditor::layout')


@section('css')
@stop


@section('content')
   <h1>Edit Language Files</h1>
   <h2>Default Lang: {!! $default_locale !!}</h2>
   <div class="row">
      <div class="col-md-12" style="border: solid thin #eeeeee; padding: 0 10px">
         <div class="table-responsive">
            <table class="table table-striped" style="width: 100%; margin: 5px 0" >
               <thead>
                  <tr>
                     <th><button id="btn-create-file">Create New File</button></th>
                     <th><button id="add-default-str">Add New String</button></th>
                     <th><button id="add-lang-folder" style="float: right">Add New Language</button>
                         <button id="save-default">Save Changes</button>
                     </th>
                  </tr>
               
                  <tr style="background-color: #eeeeff">
                     <th>
                        Language Files for {!! $default_locale !!}<br />
                        <select name="file-select">
                           @foreach($default_files as $single)
                              @if ($single == $default_files[0])  
                                 <option value="{!! $single !!}" selected="selected">{!! $single !!}</option>
                              @else
                                 <option value="{!! $single !!}" >{!! $single !!}</option>
                              @endif 
                           @endforeach
                        </ul>
                     </th>      
                     <th>
                        <span>Base Language: </span>
                        <select name="language1-select">
                           @foreach($all_languages as $index => $lang)
                              @if ($index == $default_locale)
                                 <option value="{{ $index }}" selected="selected">{!! (strlen($index) == 2 ? $index . '&nbsp;&nbsp;&nbsp;' : $index) . ' - ' . $lang['name'] !!}</option>
                              @else
                                 <option value="{{ $index }}">{!! (strlen($index) == 2 ? $index . '&nbsp;&nbsp;&nbsp;' : $index) . ' - ' . $lang['name'] !!}</option>
                              @endif
                           @endforeach         
                        </select>
                     
                     
                      </th>
                     <th>
                        <span>Compare to: </span>
                        <select name="language2-select">
                           @foreach($enabled_langs as $index => $lang)
                              @if ($index == $locale2)
                                 <option value="{{ $index }}" selected="selected">{!! (strlen($index) == 2 ? $index . '&nbsp;&nbsp;&nbsp;' : $index) . ' - ' . $lang !!}</option>
                              @else
                                 <option value="{{ $index }}">{!! (strlen($index) == 2 ? $index . '&nbsp;&nbsp;&nbsp;' : $index) . ' - ' . $lang !!}</option>
                              @endif
                           @endforeach         
                        </select>

                        
                     </th>
                  </tr>
                  <tr>
                     <th class="text-center"><strong>Alias</strong></th>
                     <th class="text-center"><strong>Phrase</strong></th>
                     <th class="text-center">Translation</th>
                  </tr>
               </thead>
               <tbody id="table-body">
      
      
      
               </tbody>
            </table>
            
            
         </div>
      </div>
            
   </div>
   <br />
   <br />
   <br />
   <br />

@stop




