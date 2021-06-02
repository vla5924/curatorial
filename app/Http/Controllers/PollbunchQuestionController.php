<?php

namespace App\Http\Controllers;

use App\Models\Pollbunch;
use App\Models\PollbunchAnswer;
use App\Models\PollbunchQuestion;
use ErrorException;
use Illuminate\Http\Request;

class PollbunchQuestionController extends Controller
{
    const PREFIX_MULTIPLE = '#';
    const PREFIX_CORRECT = '#';

    public function store(Pollbunch $pollbunch, string $questionData)
    {
        $arr = explode(PHP_EOL, $questionData);
        if (count($arr) < 2) {
            throw new ErrorException('Invalid question data');
        }

        $text = array_shift($arr);
        $multiple = false;
        if ($text[0] == self::PREFIX_MULTIPLE) {
            $multiple = true;
            $text = substr($text, 1);
        }

        $question = new PollbunchQuestion;
        $question->pollbunch_id = $pollbunch->id;
        $question->text = $text;
        $question->multiple = $multiple;
        $question->save();

        foreach ($arr as $text) {
            $correct = false;
            if ($text[0] == self::PREFIX_CORRECT) {
                $correct = true;
                $text = substr($text, 1);
            }
            $answer = new PollbunchAnswer;
            $answer->pollbunch_question_id = $question->id;
            $answer->text = $text;
            $answer->correct = $correct;
            $answer->save();
        }

        return $question;
    }
}
