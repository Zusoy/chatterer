<?php

declare(strict_types=1);

namespace Test\Acceptance\Context;

use Infra\Assert\Assert;
use Infra\Symfony\Security\AuthCookie;
use RuntimeException;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Test\Acceptance\Context;

final class Login extends Context
{
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $emailAddress = null;
    private ?string $plainPassword = null;

    /**
     * @BeforeScenario
     */
    public function reset(): void
    {
        $this->firstName = null;
        $this->lastName = null;
        $this->emailAddress = null;
        $this->plainPassword = null;

        $this->persistence->clear();
    }

    /**
     * @Given I have an account
     */
    public function iHaveAnAccount(): void
    {
        $this->firstName = $this->faker->firstName;
        $this->lastName = $this->faker->lastName;
        $this->emailAddress = $this->faker->unique()->email();
        $this->plainPassword = $this->faker->password(minLength: 8);

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
     * @When I authenticate with my email and my password
     */
    public function iAuthenticateWithMyEmailAndMyPassword(): void
    {
        if (null === $this->emailAddress || null === $this->plainPassword) {
            throw new RuntimeException('No valid account created during the current scenario');
        }

        $this->http->post(
            uri: '/auth',
            content: [
                'username' => $this->emailAddress,
                'password' => $this->plainPassword,
            ]
        );
    }

    /**
     * @When I authenticate with my email but a wrong password
     */
    public function iAuthenticateWithMyEmailButAWrongPassword(): void
    {
        if (null === $this->emailAddress) {
            throw new RuntimeException('No valid account created during the current scenario');
        }

        $this->http->post(
            uri: '/auth',
            content: [
                'username' => $this->emailAddress,
                'password' => 'notavalidpassword',
            ]
        );
    }

    /**
     * @When I authenticate with a wrong email and a wrong password
     */
    public function iAuthenticateWithAWrongEmailAndAWrongPassword(): void
    {
        $this->http->post(
            uri: '/auth',
            content: [
                'username' => 'notvalidemail@gmail.com',
                'password' => 'notavalidpassword'
            ]
        );
    }

    /**
     * @Then I should be authenticated
     */
    public function iShouldBeAuthenticated(): void
    {
        if (!$lastResponse = $this->http->getLastResponse()) {
            throw new RuntimeException('No authentication requested during the current scenario');
        }

        Assert::that($lastResponse->getStatusCode())->eq(Response::HTTP_OK);
        $cookies = $lastResponse->headers->getCookies();

        Assert::that(count($cookies))->greaterThan(0);

        $filtered = array_filter(
            $cookies,
            fn (Cookie $cookie): bool => $cookie->getName() === AuthCookie::NAME
        );

        Assert::that(count($filtered))->eq(1);
    }

    /**
     * @Then I should not be authenticated
     */
    public function iShouldNotBeAuthenticated(): void
    {
        if (!$lastResponse = $this->http->getLastResponse()) {
            throw new RuntimeException('No authentication requested during the current scenario');
        }

        $cookies = $lastResponse->headers->getCookies();
        $filtered = array_filter(
            $cookies,
            fn (Cookie $cookie): bool => $cookie->getName() === AuthCookie::NAME
        );

        Assert::that(count($filtered))->eq(0);
        Assert::that($lastResponse->getStatusCode())->eq(Response::HTTP_FORBIDDEN);
    }
}
