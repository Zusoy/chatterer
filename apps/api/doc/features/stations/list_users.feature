Feature: List station members
  In order to see station members
  As a regular user
  I need to be able to list station members

  Scenario: List station members as member
    Given I am a user
    And There is an existing "Test" station
    And I am member of the station
    And There is multiple members in the station
    When I list members of the station
    Then I should see the list of members in the station

  Scenario: Not authorized to list members of station without being member
    Given I am a user
    And There is an existing "Test" station
    And I am not member of the station
    And There is multiple members in the station
    When I list members of the station
    Then I should be notified that I'm not authorized for operation "station:list_users"
