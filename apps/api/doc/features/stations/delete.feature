Feature: Delete Station
  In order to manage stations
  As an admin
  I need to be able to delete station

  Scenario: Delete a station as admin
    Given I am an admin
    And There is an existing "Test" station
    When I delete the station
    Then I should be notified that the station is deleted

  Scenario: Not authorized to delete a station as regular user
    Given I am a user
    And There is an existing "Test" station
    When I delete the station
    Then I should be notified that I'm not authorized for operation "station:delete"

  Scenario: Fail to delete an non existing station
    Given I am an admin
    When I delete an non existing station
    Then I should be notified that the station does not exists
