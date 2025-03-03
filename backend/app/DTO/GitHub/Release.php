<?php

declare(strict_types=1);

namespace App\DTO\GitHub;

use App\Contracts\DtoObject;

final class Release implements DtoObject
{
    public function __construct(
        public readonly int $id,
        public readonly string $url,
        public readonly string $name,
        public readonly string $tag_name,
        public readonly bool $prerelease,
        public readonly string $body,
        public readonly string $published_at,
        public readonly string $html_url,
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
