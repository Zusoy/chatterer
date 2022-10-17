<?php

namespace Application\Synchronization;

class Push
{
    public function __construct(
        protected Type $type,
        protected string $context,
        protected string $identifier,
        protected mixed $payload = null
    ) {
    }

    public function getHash(): string
    {
        return md5("{$this->type->value}#{$this->context}#{$this->identifier}");
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getContext(): string
    {
        return $this->context;
    }

    public function getPayload(): mixed
    {
        return $this->payload;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return string[]
     */
    public function getTopics(): array
    {
        $topics = ["$this->context/list"];

        if (Type::UPDATE === $this->type) {
            $topics[] = "$this->context/$this->identifier";
        }

        return $topics;
    }
}
