# Contributing to CNCF.io

This document describes guidelines for contributing to the CNCF.io git repository. Everyone is welcome to contribute to this project. Please read and follow the [CNCF Code of Conduct](https://github.com/cncf/foundation/blob/master/code-of-conduct.md) to ensure that everyone has a positive experience.

## Open source

All code in and contributions to this repository are open source and covered by the [MIT license](https://github.com/cncf/cncf.io/blob/main/LICENSE).

## Issues and discussions

We use [GitHub Issues](https://github.com/cncf/cncf.io/issues) to track all issues, bug reports, discussions and work for the CNCF.io website. Please feel encouraged to participate by [creating an issue](https://github.com/cncf/cncf.io/issues/new), commenting on an existing issue, or working to solve an issue.

We use [GitHub Projects](https://github.com/cncf/cncf.io/projects/1) to manage the prioritization and stages of work of each issue. We also tag issues when they are blocked in any way.

## Working on an issue

Before starting work on an issue, please check it is not already assigned to someone and not already in progress. If the issue is open, and you can complete it, please comment on the issue that you plan to start work on it to let the team know.

## WordPress database

Due to how WordPress works, much of the CNCF.io website is stored inside a database. Because the database contains usernames, passwords and other information, the data is not available to users outside the CNCF organization. This may limit some of the issues that can be worked on by the community. However the website repo should work with an empty WordPress database and this is the advised approach to take for external contributors. If you run into problems, please open a support issue describing them.

## Contribution flow

Follow these instructions when working on an issue:

1. Fork the repo to your own GitHub account.
2. Create a branch from where you want to base your work (usually ```main```). Example ```git checkout -b my-new-feature```).
3. Read the ```readme.md``` to understand how to set up a local development environment.
4. Make your changes and arrange them in readable commits.
5. Run your changes through the PHPCS WordPress coding standards to ensure your code is compliant.
6. Commit your changes while referencing the issue number in the commit message. For example, if you are working on issue #888, your commit message could be ```#888, Fixed typo```. Sign your commit.
7. Push to your branch.
8. Make sure your branch is up to date with upstream base branch (eg. ```main```).
9. Create a new Pull Request (PR) describing the work that has been done.
10. Await review of your PR.

## Thank you!

Thank you for your contributions. We appreciate your help and look forward to collaborating with you!
