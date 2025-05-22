<?php

declare(strict_types=1);

namespace App\DTO\GitHub;

use App\Contracts\DtoObject;

final readonly class Release implements DtoObject
{
    public function __construct(
        public int $id,
        public string $url,
        public string $name,
        public string $tag_name,
        public bool $prerelease,
        public string $body,
        public string $published_at,
        public string $html_url,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['url'],
            $data['name'],
            $data['tag_name'],
            $data['prerelease'],
            $data['body'],
            $data['published_at'],
            $data['html_url'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'name' => $this->name,
            'tag_name' => $this->tag_name,
            'prerelease' => $this->prerelease,
            'body' => $this->body,
            'published_at' => $this->published_at,
            'html_url' => $this->html_url,
        ];
    }
}
