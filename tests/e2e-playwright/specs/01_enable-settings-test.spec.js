/**
 * WordPress dependencies
 */
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');

test.describe('Check settings page', () => {
    test.beforeEach(async ({ admin }) => {
        await admin.visitAdminPage('options-general.php?page=wp-mention-links');
    });
    test('Perform Checking All the contents of the page is present', async ({ admin, page, editor }) => {
        
        // Focus and validate all the settings is present or not.
        await page.focus('#wpml_user_field_to_use');
        await page.focus("label[for='posts_checkbox']");
        await page.focus("label[for='pages_checkbox']")

    });
    test('Perform Click option and save settings', async ({ admin, page, editor }) => {
        // Focus
        await page.focus('#wpml_user_field_to_use');
        // Select username
        await page.locator('#wpml_user_field_to_use').selectOption('username'); 

        // Check post and pages are properly checked or not
        const post_check= await page.locator("label[for='posts_checkbox']").isChecked();
        const page_check = await page.locator("label[for='pages_checkbox']").isChecked();
        //console.log(post_check, page_check);
        // ensure both element are checked
        if ( post_check == false){
            await page.locator("label[for='posts_checkbox']").check();
        }


        if (page_check == false) {
            await page.locator("label[for='pages_checkbox']").check();
        } 

        // save and verify
        await page.locator("input[id='submit']").click();
        await page.focus("div[id='setting-error-settings_updated']");

        // Check for the final time the elements are saved after save button
        expect(await page.locator("label[for='posts_checkbox']").isChecked()).toBeTruthy();
        expect(await page.locator("label[for='pages_checkbox']").isChecked()).toBeTruthy();
       
    });

});