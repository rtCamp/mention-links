/**
 * WordPress dependencies
 */
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');

test.describe('Check post Create setting', () => {
    test.beforeEach(async ({ admin }) => {
        await admin.visitAdminPage('options-general.php?page=wp-mention-links');
    });
    test('Set post only setting and validate username', async ({ admin, page, editor }) => {
        // Focus
        await page.focus('#wpml_user_field_to_use');
        // Select username
        await page.locator('#wpml_user_field_to_use').selectOption('username');

        // Check post page
        const post_check = await page.locator("label[for='posts_checkbox']").isChecked();
        const page_check = await page.locator("label[for='pages_checkbox']").isChecked();
        //console.log(post_check, page_check);
        // ensure both element are checked
        if (post_check == false) {
            await page.locator("label[for='posts_checkbox']").check();
        } else {
            console.log("Post is selected")
        }
        if (page_check == true) {
            await page.locator("label[for='pages_checkbox']").uncheck();
        } else {
            console.log("Already unchecked")
        }
        // save and verify
        await page.locator("input[id='submit']").click();
        await page.focus("div[id='setting-error-settings_updated']");

        // Check for the final time the elements are saved after save button
        expect(await page.locator("label[for='posts_checkbox']").isChecked()).toBeTruthy();
        expect(await page.locator("label[for='pages_checkbox']").isChecked()).toBeFalsy();
    });
    test('Create a new post and check mention in both end', async ({ admin, page, editor }) => {
        // Create new post page
        await admin.visitAdminPage("post-new.php");
        //await page.click('[aria-label="Close dialog"]'); // close dialog
        // Provide page title
        //await page.waitForSelector('role=textbox[name="Add title"i]');
        await page.locator('role=textbox[name="Add title"i]').click();
        await page.type(
            ".editor-post-title__input",
            "Dummy Post"
        ); // provide title name

        // Click on paragraph block
        await editor.insertBlock({
            name: "core/paragraph",
        });
        // Validate backend
        await page.keyboard.type("@automation");
        await page.focus('div.popover-slot > div');
        await page.locator('div.popover-slot > div').click();
        //Validate frontend
        // pusblish
        await page.click(".editor-post-publish-panel__toggle");
        // Double check, click again on publish button
        await page.click(".editor-post-publish-button");
        // A success notice should show up
        page.locator(".components-snackbar");

        await page.locator("a[class='components-button is-primary']").click();
        await expect(page.locator("role=link[name='automation']").first()).not.toBeNull();
    });


});