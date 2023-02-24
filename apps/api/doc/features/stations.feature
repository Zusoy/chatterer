Feature: Access to stations
  In order to join stations
  As a user
  I need to access to all stations

  Scenario: List all stations
    Given I am an user
    When There is some existing stations
    Then I can list all stations
