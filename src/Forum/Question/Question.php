<?php // src/Forum/Question/Question.php

namespace Forum\Question;

use Symfony\Component\Validator\Constraints as Assert;

class Question
{
    /** @var int */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Por favor, indique el título de su pregunta")
     */
    private $title;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Por favor, describa su pregunta")
     */
    private $description;

    /** @var string */
    private $author;

    /** @var \DateTime */
    private $createdAt;

    /** @var bool */
    private $resolved = false;

    public function __construct($title, $description, $author, \DateTime $createdAt = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->createdAt = $createdAt ?: new \DateTime('now');
    }

    public function getId() { return $this->id; }

    public function setId($id) { $this->id = $id; }

    public function getTitle() { return $this->title; }

    public function setTitle($title) { $this->title = $title; }

    public function getDescription() { return $this->description; }

    public function setDescription($description) { $this->description = $description; }

    public function getAuthor() { return $this->author; }

    public function getCreatedAt() { return $this->createdAt; }

    public function isResolved() { return $this->resolved; }

    public function markAsResolved() { $this->resolved = true; }
}
