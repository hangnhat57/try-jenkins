#!/usr/bin/env groovy
properties([
    pipelineTriggers([
        [$class: "GitHubPushTrigger"]
    ])
])

node {
    buildStep("Run") {
        deleteDir()
        checkout scm
        setBuildStatus('Pendinggggg!', "PENDING")
        sh 'git merge origin/master'
        sh 'cp .env.example .env'
        sh 'composer install'
        sh 'php artisan key:generate'
        sh 'vendor/bin/phpunit'
    }
    setBuildStatus('Build success!', "SUCCESS")
}

void setBuildStatus(String message, String state) {
  step([
        $class: "GitHubCommitStatusSetter",
        reposSource: [$class: "ManuallyEnteredRepositorySource", url: "https://github.com/gsmartsolutions/try-jenkins"],
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
    step([
        $class: 'Mailer',
        recipients: 'tucq88@gmail.com',
        notifyEveryUnstableBuild: true,
        sendToIndividuals: true
    ]);
}

void buildStep(String message, Closure closure) {
  stage(message);
  try {
    closure();
  } catch (Exception e) {
    notifyByMail();
    setBuildStatus('Build failed', "FAILURE");
  }
}