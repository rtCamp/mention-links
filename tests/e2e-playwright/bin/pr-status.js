#!/usr/bin/env node
// Octokit.js
// https://github.com/octokit/core.js#readme

const { Octokit } = require("@octokit/core");

const octokit = new Octokit({
    auth: process.env.TOKEN,
});

octokit.request("POST /repos/{org}/{repo}/statuses/{sha}", {
    org: "rtCamp",
    repo: "mention-links",
    sha: process.env.SHA ? process.env.SHA : process.env.COMMIT_SHA,
    state: "success",
    conclusion: "success",
    target_url:
        "https://www.tesults.com/results/rsp/view/results/project/adc9cdec-9317-40aa-afd7-eb38cc1696ec",
    description: "Successfully synced to Tesults",
    context: "E2E Test Result",
});