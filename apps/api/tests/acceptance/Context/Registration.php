<?php

declare(strict_types=1);

namespace Test\Acceptance\Context;

use Domain\Model\User\Role;
use Infra\Assert\Assert;
use Symfony\Component\HttpFoundation\Response;
use Test\Acceptance\Context;

final class Registration extends Context
{
    private ?string $emailAddress = null;
    private ?string $plainPassword = null;
    private ?string $firstName = null;
    private ?string $lastName = null;

    /**
     * @BeforeScenario
     */
    public function reset(): void
    {
        $this->emailAddress = null;
        $this->plainPassword = null;
        $this->firstName = null;
        $this->lastName = null;

        $this->persistence->clear();
    }

    /**
     * @Given I am a visitor
     */
    public function iAmAVisitor(): void
    {
    }

    /**
     * @When I send a valid email and a valid password
     */
    public function iSendAValidEmailAndPassword(): void
    {
        $this->emailAddress = $this->faker->unique()->email();
        $this->plainPassword = $this->faker->password(minLength: 8);
        $this->firstName = $this->faker->firstName;
        $this->lastName = $this->faker->lastName;

        $response = $this->http->post(
            uri: '/register',
            content: [
                'firstname' => $this->firstName,
                'lastname'  => $this->lastName,
                'email'     => $this->emailAddress,
                'password'  => $this->plainPassword,
            ]
        );

        Assert::that($response->getStatusCode())->eq(Response::HTTP_CREATED);
    }

    /**
     * @When I send an email already used
     */
    public function iSendAnEmailAlreadyUsed(): void
    {
        $usedEmailAddress = $this->faker->unique()->email();

        $response = $this->http->post(
            uri: '/register',
            content: [
                'firstname' => $this->faker->firstName,
                'lastname'  => $this->faker->lastName,
                'email'     => $usedEmailAddress,
                'password'  => $this->faker->password(minLength: 8)
            ]
        );

        Assert::that($response->getStatusCode())->eq(Response::HTTP_CREATED);

        $this->http->post(
            uri: '/register',
            content: [
                'firstname' => $this->faker->firstName,
                'lastname'  => $this->faker->lastName,
                'email'     => $usedEmailAddress,
                'password'  => $this->faker->password(minLength: 8)
            ]
        );
    }

    /**
     * @When I send an invalid email
     */
    public function iSendAnInvalidEmail(): void
    {
        $this->http->post(
            uri: '/register',
            content: [
                'firstname' => $this->faker->firstName,
                'lastname'  => $this->faker->lastName,
                'email'     => 'invalidemail',
                'password'  => $this->faker->password(minLength: 8)
            ]
        );
    }

    /**
     * @When I send an invalid password
     */
    public function iSendAnInvalidPassword(): void
    {
        $this->http->post(
            uri: '/register',
            content: [
                'firstname' => $this->faker->firstName,
                'lastname'  => $this->faker->lastName,
                'email'     => $this->faker->unique()->email(),
                'password'  => '123',
            ]
        );
    }

    /**
     * @Then the account should be created
     */
    public function theAccountShouldBeExisted(): void
    {
        $account = $this->persistence->users->findByEmail($this->emailAddress);

        Assert::that($account === null)->false();
        Assert::that($account->getFirstname())->eq($this->firstName);
        Assert::that($account->getLastname())->eq($this->lastName);
        Assert::that($account->getEmail())->eq($this->emailAddress);
        Assert::that($account->getRoles())->eq([ Role::USER->value ]);
    }

    /**
     * @Then I should be notified that the account already exists
     */
    public function iShouldBeNotifiedThatTheAccountAlreadyExists(): void
    {
        $lastResponse = $this->http->getLastResponse();
        $payload = $this->http->getLastJson();

        Assert::that($lastResponse->getStatusCode())->eq(Response::HTTP_BAD_REQUEST);
        Assert::that($payload)->keyExists('error');
        Assert::that(preg_match('/already exists/', $payload['error']['message']))->eq(1);
    }

    /**
     * @Then I should be notified that the email is invalid
     */
    public function iShouldBeNotifiedThatTheEmailIsInvalid(): void
    {
        $lastResponse = $this->http->getLastResponse();
        $payload = $this->http->getLastJson();

        Assert::that($lastResponse->getStatusCode())->eq(Response::HTTP_BAD_REQUEST);
        Assert::that($payload)->keyExists('error');
        Assert::that($payload['error']['extra'])->keyExists('email');
        Assert::that(preg_match('/Value "invalidemail" was expected to be a valid e-mail address./', $payload['error']['extra']['email'][0]['message']))->eq(1);
    }

    /**
     * @Then I should be notified that the password is invalid
     */
    public function iShouldBeNotifiedThatThePasswordIsInvalid(): void
    {
        $lastResponse = $this->http->getLastResponse();
        $payload = $this->http->getLastJson();

        Assert::that($lastResponse->getStatusCode())->eq(Response::HTTP_BAD_REQUEST);
        Assert::that($payload)->keyExists('error');
        Assert::that($payload['error']['extra'])->keyExists('password');
        Assert::that(preg_match('/should have at least 8 characters, but only has 3 characters/', $payload['error']['extra']['password'][0]['message']))->eq(1);
    }
}
