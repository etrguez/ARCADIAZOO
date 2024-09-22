<?php

class Image
{
    private $image_id;
    private $entity_id;
    private $url;

    public function __construct($image_id, $entity_id, $url)
    {
        $this->image_id = $image_id;
        $this->entity_id = $entity_id;
        $this->url = $url;
    }

    public function getEntityId(): string
    {
        return $this->entity_id;
    }

    public function setEntityId(int $newEntityId): void
    {
        $this->entity_id = $newEntityId;
    }

    public function getImageId(): string
    {
        return $this->image_id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
