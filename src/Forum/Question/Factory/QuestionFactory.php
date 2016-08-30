<?php // src/Forum/Question/Factory/QuestionFactory.php

namespace Forum\Question\Factory;

use Forum\Question\Question;

class QuestionFactory
{
    /**
     * Crea un objeto Question a partir de un arreglo
     *
     * @param array $data
     * @return Question
     */
    public function createFromArray($data)
    {
        $question = new Question(
            $data['title'],
            $data['description'],
            $data['author'],
            new \DateTime($data['created'])
        );

        $question->setId((int)$data['id']);
        $data['resolved'] and $question->markAsResolved();

        return $question;
    }
}
