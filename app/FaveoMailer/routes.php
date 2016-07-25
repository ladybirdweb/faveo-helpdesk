<?php
Route::group(['middleware'=>['web','auth']],function(){
    Route::get('test/test/test',function(){
        return "yes";
    });
});