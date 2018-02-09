# PHP CI/CD


Implementing CI/CD for TwentyCI. At first, we defined 3 MVPs
    

  - Build a pipeline to checkout - build - deploy code on CI
  - Check Code quality - Execute tests 
  - Create bots for auto fixing errors.

### Tech

  - CI platform:
        I choosed Jenkins as CI platform. Its supporting community is huge. Beside, it has a lot of plugins. 
        I still want to experiment in CircleCI and GitLab, `Will get indepth later`
  - Environment: 
  Linux or Docker. Currently I'm using Linux to build jobs. Docker should be a good solution too. 


### MVP 1

Build a pipeline to checkout - build - deploy code on CI

- Technical Requirements: 
    -  Project Source Control using Github. So there are many options to poll - hook changes: 
        ##### Options:
        1. Multi-branch pipeline: 
         We can scan projects, select branches to build, hook any changes following rules defined, then build project 
        2. Pull Request Builder: Almost the same.