<?php
use App\Translation;

function flash($message, $type = 'danger')
{
    Session::flash('flash-message', $message);
    Session::flash('flash-type', $type);
}

function t($word, $language = '')
{
    if (Auth::check()) {
        $language = $language ?: \Session::get('personlized-language-ar' . \Auth::user()->id, \Config::get('app.locale'));
        if ($word instanceof \Illuminate\Support\Collection) {
            $translate_array = collect();
            foreach ($word as $key => $item) {
                $word_exist = Translation::where('word', 'like', $item)
                    ->where('language', $language)->first();

                if ($word_exist) {
                    if ($word_exist->translation != '') {
                        $translate_array->put($key, $word_exist->translation);
                    }

                } else {
                    $translate_array->put($key, $item);
                }
            }
            return $translate_array;
        }

        $word_exist = Translation::where('word', 'like', $word)
            ->where('language', $language)->first();

        if ($word_exist) {
            if ($word_exist->translation != '') {
                return $word_exist->translation;
            }
            return $word_exist->word;
        }
        return $word;
//        $newWord = new Translation();
//        $newWord->word = $word;
////        $newWord->language = $language;
//        $newWord->save();
//        return $newWord->word;
    }


}