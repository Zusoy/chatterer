Feature: Create an account
  In order to create my account and use the application
  As a visitor
  I need to be able to register using an email and a password

  Scenario: Register with a valid email and password
    Given I am a visitor
    When I send a valid email and a valid password
    Then the account should be created

  Scenario: Fail to register when the email is already being used
    Given I am a visitor
    When I send an email already used
    Then I should be notified that the account already exists

  Scenario: Fail to register when the email is invalid
    Given I am a visitor
    When I send an invalid email
    Then I should be notified that the email is invalid

  Scenario: Fail to register when the password is invalid
    Given I am a visitor
    When I send an invalid password
    Then I should be notified that the password is invalid
