/**
 * WordPress dependencies
 */
const { test } = require('@wordpress/e2e-test-utils-playwright');
const { MentionLinks } = require('../page/MentionLinks.js');
test.describe('Check page Create setting', () => {
    test('Set page only setting and validate mention in both end', async ({ page }) => {
        const mentionLinkobj = new MentionLinks(page);
        await mentionLinkobj.navigateToSettingPage();
        await mentionLinkobj.selectDisplayname();
        await mentionLinkobj.checkOnlyPageCheckbox();
        await mentionLinkobj.saveSettings();
        await mentionLinkobj.validateOnlyPageChecked();
    });
    test('Create a new page and check DisplayName', async ({ admin, page, editor }) => {
        const mentionLinkobj = new MentionLinks(page);
        // Create new page
        await admin.createNewPost({ postType: 'page', title: 'Dummy page' })
        // Click on paragraph block
        await editor.insertBlock({
            name: "core/paragraph",
        });
        await mentionLinkobj.validateBackend();
        await mentionLinkobj.publishPagePost();
        await mentionLinkobj.validateFrontend();
    });
});