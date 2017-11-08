#!/usr/bin/env groovy
REPO_URL = "https://github.com/gsmartsolutions/try-jenkins"
NOTIFY_TO = "tucq88@gmail.com"

properties([
    pipelineTriggers([
        [$class: "GitHubPushTrigger"]
    ])
])

node {
    echo REPO_URL
    echo NOTIFY_TO
    // buildStep("Run") {
    //     deleteDir()
    //     checkout scm
    //     setBuildStatus('Pendingggggg!', "PENDING")
    //     sh 'git merge origin/master'
    //     sh 'cp .env.example .env'
    //     sh 'composer install'
    //     sh 'php artisan key:generate'
    //     sh 'vendor/bin/phpunit'
    // }
    // setBuildStatus('Build success!', "SUCCESS")
}

void setBuildStatus(String message, String state) {
  step([
        $class: "GitHubCommitStatusSetter",
        reposSource: [$class: "ManuallyEnteredRepositorySource", url: env.repo ],
        contextSource: [$class: "ManuallyEnteredCommitContextSource", context: "ci/jenkins/build-status"],
        errorHandlers: [[$class: "ChangingBuildStatusErrorHandler", result: "FAILURE"]],
        statusResultSource: [
            $class: "ConditionalStatusResultSource",
            results: [
                [ $class: "AnyBuildResult", message: message, state: state ]
            ]
        ]
  ]);
}

void notifyByMail() {
    echo env.notifyTo
    emailext(
        to: env.notifyTo,
        subject: "${currentBuild.result}: ${env.JOB_NAME} [${env.BUILD_NUMBER}]",
        body: "Please go to ${env.BUILD_URL}."
    )
}

void buildStep(String message, Closure closure) {
  stage(message);
  try {
    closure();
  } catch (Exception e) {
    setBuildStatus('Build failed', "FAILURE");
  }
}
