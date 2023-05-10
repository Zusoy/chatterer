<?php

namespace Infra\Symfony\Security\Voter;

use Domain\Model\User;
use Domain\Security\Operation;
use Domain\Security\Rule;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class DomainRuleVoter extends Voter
{
    /**
     * @var array<string,Rule[]>
     */
    private array $mappedRules = [];

    /**
     * @param iterable<Rule> $rules
     */
    public function __construct(iterable $rules)
    {
        $this->setRules($rules);
    }

    /**
     * @param iterable<Rule> $rules
     */
    private function setRules(iterable $rules): void
    {
        foreach ($rules as $rule) {
            foreach ($rule->getOperations() as $operation) {
                $this->mappedRules[$operation->value][] = $rule;
            }
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $subject
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        $operation = strtolower($attribute);

        return array_key_exists($operation, $this->mappedRules) && 0 !== count($this->mappedRules[$operation]);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $operation = strtolower($attribute);

        $user = null;

        if (is_array($subject) && array_key_exists('user', $subject)) {
            $user = $subject['user'];
            unset($subject['user']);
        }

        if (!$user) {
            $user = $token->getUser();
        }

        if (!$user instanceof User) {
            return $token instanceof NullToken; // no user is defined (because of a CLI command for instance)
        }

        $context = is_array($subject) && array_key_exists('context', $subject) ? $subject['context'] : $subject;

        foreach ($this->mappedRules[$operation] as $rule) {
            if (!$rule->allows($user, Operation::from($operation), $context ?: null)) {
                return false;
            }
        }

        return true;
    }
}
