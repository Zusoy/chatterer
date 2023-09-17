Feature: List Forums
  In order to participate at forums discussions
  As a regular user
  I need to be able to list forums from station

  Scenario: List forums of a station
    Given I am a user
    And There is the station "Test"
    And I am member of the station
    And There is multiple forums in the station
    When I list all forums of the station
    Then I should see the list of all forums in this station

  Scenario: Not authorized to list forums of station without being member
    Given I am a user
    And There is the station "Company"
    But I am not member of the station
    When I list all forums of the station
    Then I should be notified that I'm not authorized for operation "station:list_forums"
