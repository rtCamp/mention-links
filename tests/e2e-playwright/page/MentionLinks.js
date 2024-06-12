const { expect } = require("@playwright/test");
const { selectors } = require('../utils/selectors')
exports.MentionLinks = class MentionLinks {
    constructor(page) {
        this.page = page
    }
 // this functions is to navigate to the Mention link Setting page
 async navigateToSettingPage(){
     await this.page.goto("./wp-admin/options-general.php?page=wp-mention-links",{waitUntil:"load"});
 }

 // this function is used to validate all the setting is presnet on the page.
 async validateElements(){
     // Focus and validate all the settings is present or not.
     await this.page.focus(selectors.userField);
     await this.page.focus(selectors.postCheckbox);
     await this.page.focus(selectors.pageCheckbox);
 }
 // this function is used to select Username
 async selectUsername(){
     await this.page.focus(selectors.userField);
     await this.page.locator(selectors.userField).selectOption('username');
 }
 // this function is used to select Displayname
 async selectDisplayname(){
     await this.page.focus(selectors.userField);
     await this.page.locator(selectors.userField).selectOption('displayname');
 }
// this function is used to check both page and post Checkbox
async checkBothPagePostCheckbox(){
    await this.page.locator(selectors.postCheckbox).check();
    await this.page.locator(selectors.pageCheckbox).check();
}
// this functions is used to validate both post and page checkbox are checked
async validateBothPostPageChecked(){
    // Check for the final time the elements are saved after save button
    expect(await this.page.locator(selectors.postCheckbox).isChecked()).toBeTruthy();
    expect(await this.page.locator(selectors.pageCheckbox).isChecked()).toBeTruthy();
}
// this function is used to Save settings and verify
async saveSettings(){
    await this.page.locator(selectors.submitButton).click();
    await this.page.focus(selectors.saveMessage);
}
// this function is used to check only page and uncheck post
async checkOnlyPageCheckbox(){
    await this.page.locator(selectors.pageCheckbox).check();
    await this.page.locator(selectors.postCheckbox).uncheck();
}
// this function is used to check only post and uncheck page
async checkOnlyPostCheckbox(){
    await this.page.locator(selectors.postCheckbox).check();
    await this.page.locator(selectors.pageCheckbox).uncheck();
}
// this function is used to validate checked page and unchecked post
async validateOnlyPageChecked(){
    expect(await this.page.locator(selectors.pageCheckbox).isChecked()).toBeTruthy();
    expect(await this.page.locator(selectors.postCheckbox).isChecked()).toBeFalsy();
}
// this function is used to validate checked page and unchecked post
async validateOnlyPostChecked(){
    expect(await this.page.locator(selectors.postCheckbox).isChecked()).toBeTruthy();
    expect(await this.page.locator(selectors.pageCheckbox).isChecked()).toBeFalsy();
}
// this function is used to validate Mention Element is present on the Backend
async validateBackend(){
    await this.page.keyboard.type(selectors.userName);
    await this.page.focus(selectors.backendPopover);
    await expect(this.page.locator(selectors.backendPopover)).toBeVisible();
    await this.page.locator(selectors.backendPopover).click();
}
// this fucntion is used to Publish and verify page/post
async publishPagePost(){
    await this.page.click(selectors.publishToggle);
    await this.page.click(selectors.publishButton);
    await this.page.locator(selectors.successClass);
}
// this function is used to validate Mention Element is present on the Frontend
async validateFrontend(){
    await this.page.locator(selectors.viewButton).click();
    await expect(this.page.locator(selectors.userLink).first()).not.toBeNull();
    const locator = this.page.locator(selectors.userLink).first();
    await expect(locator).toBeEnabled();
}


   
}