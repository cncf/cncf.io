Feature: Change blogname and blogdescription
  As a maintainer of the site
  I want to be able to change basic settings
  So that I have control over my site

  Scenario: Saving blogname and blogdescription
    Given I am logged in as an administrator
    Given I am on the dashboard
    When I go to the "Settings > General" menu
    And I fill in "blogname" with "Awesome WordHat Test Site!"
    And I fill in "blogdescription" with "Composer + CI + Pantheon is a win!"
    And I press "submit"
    Then I should see "Settings saved."
    And I go to "/wp/wp-admin/options-general.php?page=pantheon-cache"
    And I press "Clear Cache"
    And I should see "Site cache flushed." in the ".updated" element

  Scenario: Clear the site cache
    Given I am logged in as an administrator
    Given I am on the dashboard
    When I go to "/wp/wp-admin/options-general.php?page=pantheon-cache"
    Then I should see "Clear Site Cache"
    And I should not see "Site cache flushed."

    When I press "Clear Cache"
    Then print current URL
    And I should be on "/wp/wp-admin/options-general.php?page=pantheon-cache&cache-cleared=true"
    And I should see "Site cache flushed." in the ".updated" element

  Scenario: Verify the Pantheon MU plugin is present
    Given I am logged in as an administrator
    Given I am on the dashboard
    When I go to "/wp/wp-admin/plugins.php?plugin_status=mustuse"
    Then I should see "/wp-content/mu-plugins directory are executed automatically." in the ".tablenav" element
    And I should see "Pantheon" in the "#the-list" element
 
  Scenario: Verifying blogname and blogdescription
    Given I am on the homepage
    Then I should be on the homepage
    And I should see "Awesome WordHat Test Site!" in the ".site-title > a" element
    And I should see "Composer + CI + Pantheon is a win!" in the ".site-description" element