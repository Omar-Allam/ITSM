<?php
use App\Translation;

function flash($message, $type = 'danger')
{
    Session::flash('flash-message', $message);
    Session::flash('flash-type', $type);
}

function t($word, $language = '')
{
    if(Auth::check()){
        $language = $language ?: \Session::get('personlized-language' . \Auth::user()->id, \Config::get('app.locale'));

        $word_exist = Translation::where('word', $word)
            ->where('language', $language)->first();

        if ($word_exist) {
            if ($word_exist->translation != '') {
                return $word_exist->translation;
            }
            return $word_exist->word;
        }

        $newWord = new Translation();
        $newWord->word = $word;
        $newWord->language = $language;
        $newWord->save();
        return $newWord->word;
    }


}