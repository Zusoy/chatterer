Feature: List Channels
  In order to manage channels
  As a regular user
  I need to be able to list all channels of a station

  Scenario: List channels as station member
    Given I am a user
    And There is the station "Company"
    And I am member of the station
    And There is a "Meetings" channel in the station
    And There is a "Show-Off" channel in the station
    When I list all channels of the station
    Then I should see the list of all channels in this station

  Scenario: Not authorized to list channels of station without being member
    Given I am a user
    And There is the station "Company"
    But I am not member of the station
    And There is a "Meetings" channel in the station
    And There is a "Show-Off" channel in the station
    When I list all channels of the station
    Then I should be notified that I'm not authorized for operation "station:list_channels"
