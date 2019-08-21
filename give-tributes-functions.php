<?php
/*
 * Plugin Name: Give Tributes Functions
 * Plugin URI:
 * Description: This plugin provides additional functionality to Give Tributes addon.
 * Version: 1.0
 * Author: Sam Smith
 * Author URI: gsamsmith.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * DISCLAIMER: This is provided as a solution for providing additional functionality to the Give Tributes plugin with the current markup and version of the Give plugin (version 2.5.4) and Give Tributes addon (version 1.5.4). We provide no
 * guarantees to any updates that Give may make to their plugin and we do not offer Support for this code at all. For more information please reference the custom development agreement that was agreed to and signed by both parties.
 *
 */


// Remove the requirement on Tributes field "First Name"
function give_dont_require_fields($required_fields, $form_id)
{
    if (isset($required_fields['give_tributes_first_name'])) {
        unset($required_fields['give_tributes_first_name']);
    }
    return $required_fields;
}
add_filter('give_donation_form_required_fields', 'give_dont_require_fields', 10, 2);


// Reduces the allowed number of eCard recipients to four
function give_no_more_four()
{ ?>
<script>
    // Listens for click events
    document.addEventListener('click', function(event) {

        // If click event matches plus icon in the Give form
        if (event.target.matches('.give-tributes-clone-field .give-icon-plus')) {
            // Grabs the number of active recipients
            const recipients = document.querySelectorAll(".give_tributes_send_ecard_fields").length;
            // If active reaches four the plus icon is removed
            if (recipients >= 3) {
                document.querySelectorAll(".give-tributes-clone-field .give-icon-plus").forEach(el => el.style.display = "none");
            }
        }

        // If click event matches minus icon in the Give form
        if (event.target.matches('.give-tributes-clone-field .give-icon-minus')) {

            // Looks to see if the plus icon isn't there
            const itsoff = document.querySelector(".give-tributes-clone-field .give-icon-plus").style.display
            // Displays the plus icon only if it's not visible
            if (itsoff == "none") {
                document.querySelectorAll(".give-tributes-clone-field .give-icon-plus").forEach(el => el.style.display = "block");
            }
        }
    }, false);
</script>
<?php }

add_action('give_post_form_output', 'give_no_more_four');

// Changes the "Personal Info" text in forms
function my_give_text_switcher($translations, $text, $domain)
{
    if ($domain == 'give' && $text == 'Personal Info') {
        $translations = __('Donor Info', 'give');
    }
    return $translations;
}
add_filter('gettext', 'my_give_text_switcher', 10, 3);
