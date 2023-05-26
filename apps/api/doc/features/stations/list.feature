Feature: List Stations
  In order to manage stations
  As a regular user
  I need to be able to list all stations

  Scenario: List station as member
    Given I am a user
    And There is some stations
      | name  | description |
      | Test  | test        |
      | Hello | hello       |
    When I list stations
    Then I should see the list of all stations

  Scenario: Not authorized to list stations as visitor
    Given I am a visitor
    And There is some stations
      | name  | description |
      | Test  | test        |
      | Hello | hello       |
    When I list stations
    Then I should be notified that I'm not authorized
