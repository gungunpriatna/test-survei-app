<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MattDaneshvar\Survey\Models\Entry;
use MattDaneshvar\Survey\Models\Survey;

class SurveyController extends Controller
{
    public function index()
    {

        $survey = Survey::create(['name' => 'Cat Population Survey']);

        $survey->questions()->create([
            'content' => 'How many cats do you have?',
            'type' => 'number',
            'rules' => ['numeric', 'min:0']
        ]);

        $survey->questions()->create([
            'content' => 'What\'s the name of your first cat',
        ]);

        $survey->questions()->create([
            'content' => 'Would you want a new cat?',
            'type' => 'radio',
            'options' => ['Yes', 'Oui']
        ]);

    }

        public function create()
        {
            $survey = Survey::findOrFail(1);

            return view('surveys.create', compact('survey'));

        }

        public function store(Request $request)
        {
            $survey = Survey::findOrFail(1);
            $answers = $this->validate($request, $survey->rules);


            (new Entry())->for($survey)->by(Auth::user())->fromArray($answers)->push();

            return view('surveys.create', compact('survey'));


        }
}
