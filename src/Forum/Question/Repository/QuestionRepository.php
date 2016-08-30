<?php // src/Forum/Question/Repository/QuestionRepository.php

namespace Forum\Question\Repository;

use Forum\Question\Question;

interface QuestionRepository
{
    /**
     * Agrega o Actualiza una pregunta en el repositorio.
     *
     * @param Question $question
     */
    public function save(Question $question);

    /**
     * Busca una pregunta por su id y la retorna.
     * Si no existe, rentorna null
     * @param $id
     * @return Question|null
     */
    public function find($id);

    /**
     * Retorna un arreglo de preguntas ordenados de forma descendiente.
     *
     * @return Question[]|array
     */
    public function findAll();
}
