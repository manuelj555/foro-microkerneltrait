<?php // src/Forum/Question/Repository/DbQuestionRepository.php

namespace Forum\Question\Repository;

use Doctrine\DBAL\Connection;
use Forum\Question\Factory\QuestionFactory;
use Forum\Question\Question;

class DbQuestionRepository implements QuestionRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var QuestionFactory
     */
    private $factory;

    public function __construct(Connection $connection, QuestionFactory $factory)
    {
        $this->connection = $connection;
        $this->factory = $factory;
    }

    public function save(Question $question)
    {
        if ($question->getId()) {
            $this->update($question);
        } else {
            $this->create($question);
        }
    }

    public function find($id)
    {
        $data = $this->connection->fetchAssoc('SELECT * FROM questions WHERE id = ?', [$id]);

        return $this->factory->createFromArray($data);
    }

    public function findAll()
    {
        $data = $this->connection->fetchAll('SELECT * FROM questions ORDER BY id DESC');

        $questions = [];

        foreach ($data as $item) {
            $questions[] = $this->factory->createFromArray($item);
        }

        return $questions;
    }

    private function create(Question $question)
    {
        $id = $this->connection->insert(
            'questions',
            $this->toArray($question),
            ['created' => 'datetime'] // Para que Doctrine convierte el \Datetime a string
        );

        $question->setId($id);
    }

    private function update(Question $question)
    {
        $this->connection->update(
            'questions',
            $this->toArray($question),
            ['id' => $question->getId()],
            ['created' => 'datetime'] // Para que Doctrine convierte el \Datetime a string
        );
    }

    private function toArray(Question $question)
    {
        return [
            'title' => $question->getTitle(),
            'description' => $question->getDescription(),
            'author' => $question->getAuthor(),
            'created' => $question->getCreatedAt(),
            'resolved' => $question->isResolved(),
        ];
    }
}

