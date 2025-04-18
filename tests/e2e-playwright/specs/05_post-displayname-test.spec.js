/**
 * WordPress dependencies
 */
const { test } = require('@wordpress/e2e-test-utils-playwright');
const { MentionLinks } = require('../page/MentionLinks.js');
test.describe('Check post Create setting', () => {
    test('Set post only setting and validate displayname', async ({ page }) => {
        const mentionLinkobj = new MentionLinks(page);
        await mentionLinkobj.navigateToSettingPage();
        await mentionLinkobj.selectDisplayname();
        await mentionLinkobj.checkOnlyPostCheckbox();
        await mentionLinkobj.saveSettings();
        await mentionLinkobj.validateOnlyPostChecked();
    });
    test('Create a new post and check mention in both end', async ({ admin, page, editor }) => {
        const mentionLinkobj = new MentionLinks(page);
        // Create new post 
        await admin.createNewPost({ title: 'Dummy Post' });
        // Click on paragraph block
        await editor.insertBlock({
            name: "core/paragraph",
        });
        await mentionLinkobj.validateBackend();
        await mentionLinkobj.publishPagePost();
        await mentionLinkobj.validateFrontend();
    });
});