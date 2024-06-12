/**
 * WordPress dependencies
 */
const { test } = require('@wordpress/e2e-test-utils-playwright');
const { MentionLinks } = require('../page/MentionLinks.js');
test.describe('Check settings page', () => {
    test('Perform Checking All the contents of the page is present', async ({ admin, page }) => {
        await admin.visitAdminPage('/');
        const mentionLinkobj = new MentionLinks(page);
        await mentionLinkobj.navigateToSettingPage();
        await mentionLinkobj.validateElements();
    });
    test('Perform Click option and save settings', async ({ page }) => {
        const mentionLinkobj = new MentionLinks(page);
        await mentionLinkobj.navigateToSettingPage();
        await mentionLinkobj.selectUsername();
        await mentionLinkobj.checkBothPagePostCheckbox();
        await mentionLinkobj.saveSettings();
        await mentionLinkobj.validateBothPostPageChecked();
    });
});