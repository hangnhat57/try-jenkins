#!/usr/bin/env groovy
REPO_URL = "https://github.com/hangnhat57/try-jenkins"
NOTIFY_TO = "hangnhat57@gmail.com, nhat.nguyen@twentyci.asia"

properties([
    pipelineTriggers([
        [$class: "GitHubPushTrigger"]
    ])
])

node {
    currentBuild.result = 'SUCCESS'
    try {
        stage('initial') {
            git {
            remote {
                github('test-owner/test-project')
                refspec('+refs/pull/*:refs/remotes/origin/pr/*')
            }
            branch('master')
        }
        }
        stage("prepare") {
            sh 'cp .env.example .env'
            sh 'composer install'
            sh 'php artisan key:generate'
        }
        stage("phpunit") {
            sh 'vendor/bin/phpunit'
        }
        setBuildStatus('Built successfully!', 'SUCCESS')
     } catch (error) {
        stage("report error") {
            setBuildStatus('Built failed!', 'FAILURE')
            currentBuild.result = 'FAILURE'
            notifyByMail()
        }
        throw error
     }
}

void setBuildStatus(String message, String state) {
    step([
        $class: "GitHubCommitStatusSetter",
        reposSource: [$class: "ManuallyEnteredRepositorySource", url: REPO_URL ],
        contextSource: [$class: "ManuallyEnteredCommitContextSource", context: "Jenkins"],
        errorHandlers: [[$class: "ChangingBuildStatusErrorHandler", result: "UNSTABLE"]],
        statusResultSource: [
            $class: "ConditionalStatusResultSource",
            results: [
                [ $class: "AnyBuildResult", message: message, state: state ]
            ]
        ]
    ]);
}

void notifyByMail() {
    emailext (
        to: NOTIFY_TO,
        subject: "${currentBuild.result}: ${env.JOB_NAME} [${env.BUILD_NUMBER}]",
        body: "Please go to ${env.BUILD_URL} for detail!"
    )
}