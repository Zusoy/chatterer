Feature: Invite members
  In order to invite member in a station
  As a regular user
  I need to be able to create an invitation

  Scenario: Create an invitation
    Given I am a user
    And There is an existing "Test" station
    And I am member of the station
    When I create a new invitation for the station
    Then I should be notified that the invitation is created

  Scenario: Not authorized to create station invitation without being member
    Given I am a user
    And There is an existing "Test" station
    And I am not member of the station
    When I create a new invitation for the station
    Then I should be notified that I'm not authorized for operation "station:invite"

  Scenario: Fail to invite to a station that does not exists
    Given I am a user
    When I create a new invitation for a station that does not exists
    Then I should be notified that the station does not exists
