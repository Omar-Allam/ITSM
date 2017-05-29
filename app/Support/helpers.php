<?php
use App\Translation;

function flash($message, $type = 'danger')
{
    Session::flash('flash-message', $message);
    Session::flash('flash-type', $type);
}

function t($word, $language = '')
{
    $language = $language ?: app()->getLocale();

    $word_exist = Translation::where('word', $word)
        ->where('language_id', $language)->first();

    if ($word_exist) {
        if ($word_exist->translation != '') {
            return $word_exist->translation;
        }
        return $word_exist->word;
    }

    $newWord = new Translation();
    $newWord->word = $word;
    $newWord->language_id = $language;
    $newWord->save();
    return $newWord->word;

}