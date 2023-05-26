Feature: List channel members
  In order to see channel members
  As a regular user
  I need to be able to list channel members

  Scenario: List channel members as member
    Given I am a user
    And There is the station "Company"
    And I am member of the station
    And There is a "Meetings" channel in the station
    And I am member of the channel
    And There is multiple members in the channel
    When I list all members of the channel
    Then I should see the list of the members

  Scenario: Not authorized to list channel members without being member
    Given I am a user
    And There is the station "Company"
    And I am member of the station
    And There is a "Meetings" channel in the station
    And There is multiple members in the channel
    But I am not member of the channel
    When I list all members of the channel
    Then I should be notified that I'm not authorized for operation "channel:list_users"
