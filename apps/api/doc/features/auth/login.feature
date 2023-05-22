Feature: Access to account
  In order to access my account
  As a user
  I need to be able to login using my email and my password

  Scenario: Authenticate using my email and my password
    Given I have an account
    When I authenticate with my email and my password
    Then I should be authenticated

  Scenario: Failed to authenticate with my email but wrong password
    Given I have an account
    When I authenticate with my email but a wrong password
    Then I should not be authenticated

  Scenario: Failed to authenticate with wrong email and wrong password
    Given I have an account
    When I authenticate with a wrong email and a wrong password
    Then I should not be authenticated
