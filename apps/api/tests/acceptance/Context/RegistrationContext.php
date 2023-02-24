<?php

namespace Test\Acceptance\Context;

use Domain\Model\User\Role;
use Infra\Assert\Assert;
use Test\Acceptance\Context;

final class RegistrationContext extends Context
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

        $this->database->truncate();
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

        Assert::that($response->getStatusCode())->eq(201);
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

        Assert::that($response->getStatusCode())->eq(201);

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
        $account = $this->database->users->findByEmail($this->emailAddress);

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
        $content = json_decode((string) $lastResponse->getContent(), associative: true, flags: JSON_THROW_ON_ERROR);

        Assert::that($lastResponse->getStatusCode())->eq(400);
        Assert::that($content)->keyExists('error');
        Assert::that(preg_match('/already exists/', $content['error']['message']))->eq(1);
    }

    /**
     * @Then I should be notified that the email is invalid
     */
    public function iShouldBeNotifiedThatTheEmailIsInvalid(): void
    {
        $lastResponse = $this->http->getLastResponse();
        $content = json_decode((string) $lastResponse->getContent(), associative: true, flags: JSON_THROW_ON_ERROR);

        Assert::that($lastResponse->getStatusCode())->eq(400);
        Assert::that($content)->keyExists('error');
        Assert::that($content['error']['extra'])->keyExists('email');
        Assert::that(preg_match('/Value "invalidemail" was expected to be a valid e-mail address./', $content['error']['extra']['email'][0]['message']))->eq(1);
    }

    /**
     * @Then I should be notified that the password is invalid
     */
    public function iShouldBeNotifiedThatThePasswordIsInvalid(): void
    {
        $lastResponse = $this->http->getLastResponse();
        $content = json_decode((string) $lastResponse->getContent(), associative: true, flags: JSON_THROW_ON_ERROR);

        Assert::that($lastResponse->getStatusCode())->eq(400);
        Assert::that($content)->keyExists('error');
        Assert::that($content['error']['extra'])->keyExists('password');
        Assert::that(preg_match('/should have at least 8 characters, but only has 3 characters/', $content['error']['extra']['password'][0]['message']))->eq(1);
    }
}
