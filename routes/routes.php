<?php


Route::get('/transedit', ["as" => "transedit.editlist", "uses" => "TranslationEditorController@dashboard"]);

Route::get('/transedit/page/{lang}/{comparelang}/{pagename}', ["as" => "transedit.page", "uses" => "TranslationEditorController@getLanguagePage"]);

Route::get('/transedit/dashboard', ["as" => "transedit.dashboard", "uses" => "TranslationEditorController@dashboard"]);
Route::get('/transedit/language', ["as" => "transedit.language", "uses" => "TranslationEditorController@getLanguagePage"]);
Route::get('/transedit/online', ["as" => "transedit.online", "uses" => "TranslationEditorController@getOnlinePage"]);
Route::post('/transedit/savechange', ["as" => "transedit.savechange", "uses" => "TranslationEditorController@saveChange"]);
Route::post('/transedit/createlang/{lang}', ["as" => "transedit.createlang", "uses" => "TranslationEditorController@createLang"]);
   