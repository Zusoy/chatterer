Feature: Join invitation
  In order to join station with invitation
  As a regular user
  I need to be able to join a station

  Scenario: Join a station with invitation
    Given I am a user
    And There is an existing "Test" station
    And There is an invitation to join the station
    When I join the station using the invitation token
    Then I should be notified that I joined the station

  Scenario: Fail to join a station with not existing invitation
    Given I am a user
    And There is an existing "Test" station
    When I join the station using not existing invitation token
    Then I should be notified that the invitation does not exists

  Scenario: Fail to join a station with the wrong invitation token
    Given I am a user
    And There is an existing "Test" station
    And There is an invitation to join the station
    When I join the station using wrong invitation token
    Then I should be notified that the invitation is wrong

  Scenario: Fail to join a station in which I'm already a member
    Given I am a user
    And There is an existing "Test" station
    And There is an invitation to join the station
    And I am member of the station
    When I join the station using the invitation token
    Then I should be notified that I'm already a member

  Scenario: Fail to join a station that does not exists
    Given I am a user
    When I join a non existing station
    Then I should be notified that the station does not exists
