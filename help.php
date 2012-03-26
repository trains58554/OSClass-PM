<?php
/*
 *      OSCLass – software for creating and publishing online classified
 *                           advertising platforms
 *
 *                        Copyright (C) 2010 OSCLASS
 *
 *       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>

<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 0 20px 20px;">
        <div>
            <fieldset>
                <legend>
                    <h1><?php _e('Personal Messaging for OSClass Help/FAQ', 'osclass_pm'); ?></h1>
                </legend>
                <h2>
                    <?php _e('What is the Personal Messaging for OSClass Plugin?', 'osclass_pm'); ?>
                </h2>
                <p>
                    <?php _e('The Personal Messaging for OSClass Plugin is an in house messaging system. It is a lot like the PM system on the OSClass forums.', 'osclass_pm'); ?>
                </p>
                <h2>
                    <?php _e('Do I need to edit any files for the Personal Messaging for OSClass plugin to work?', 'osclass_pm'); ?>
                </h2>
                <p>
                    <?php _e('No, All all the links are added with javascript.', 'osclass_pm'); ?>
                </p>
                <h2>
                    <?php _e('Where will the PM links show up at?', 'osclass_pm'); ?>
                </h2>
                <p>
                    <?php _e('You will see a PM link on the item page and the profile page of the user.','osclass_pm'); ?>
                </p>
                <h2>
                    <?php _e('How do I edit the email templates?', 'osclass_pm'); ?>
                </h2>
                <p>
                    <?php _e('To edit the email templates you have to go under the Email & Alerts menu. Then you will see towards the end of the list <b>email_PM_alert</b>.', 'osclass_pm'); ?>
                </p>
                <h2>
                    <?php _e('What are the dynamic tags that can be used in the "email_PM_alert" template?', 'osclass_pm'); ?>
                </h2>
                <p>
                    <?php echo'{RECIP_NAME}, {SENDER_NAME}, {WEB_URL}, {WEB_TITLE}, {PM_URL}, {PM_SUBJECT}, {PM_MESSAGE}'; ?>
                </p>
            </fieldset>
        </div>
    </div>
</div>
