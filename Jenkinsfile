node
{
     def gitCredentialsId = "5bad9593-8e80-4d49-9561-cae5564223d8";
     def gitRepository = "https://github.com/hangnhat57/try-jenkins.git";
     def gitBranch = "master";
     def slackDomain = "slack.domaim.domain";
     def slackToken = "TokenXYZ";
     def slackChannel = "#engineers";
    properties
    ([
    pipelineTriggers([
        [$class: "GitHubPushTrigger"]
            ])
    ])



    stage("Clean up") {
        sh 'rm -rf ./*' 
    }    
    stage('Checkout') {
        checkout([$class: 'GitSCM', branches: [[name: "*/"+"${gitBranch}"]], 
        doGenerateSubmoduleConfigurations: false,
        extensions: [], 
        submoduleCfg: [],
        userRemoteConfigs: [[credentialsId: "${gitCredentialsId}", url: "${gitRepository}"]]])
    }
       
    try
    {
    notifyBuild()    
    stage("Prepare") {
            sh 'cp .env.example .env'
            sh 'curl -Ol https://getcomposer.org/download/1.6.3/composer.phar'
            sh 'php composer.phar install'  
            sh 'php artisan key:generate'
        }
    stage("Unit test") {
            sh 'vendor/bin/phpunit'
        }
    stage("Deploy"){
        zip archive: true, dir: './', glob: '', zipFile: 'artifact.zip'
        sh 'mkdir target'
        sh 'cp ./artifact.zip ./target/artifact.zip'
        }    
    }
    catch(error) 
    {
        stage("report error") {
            setBuildStatus('Built failed!', 'FAILURE')
            currentBuild.result = 'FAILURE'
            
        }
        throw error
    }
    finally {
        notifyBuild(currentBuild.result)
    }

}

void setBuildStatus(String message, String state) {
    step([
        $class: "GitHubCommitStatusSetter",
        reposSource: [$class: "ManuallyEnteredRepositorySource", url: "${gitRepository}" ],
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

void notifyBuild(String buildStatus = 'STARTED') {

  buildStatus =  buildStatus ?: 'SUCCESSFUL'
  def colorName = 'RED'
  def colorCode = '#FF0000'
  def subject = "${buildStatus}: Job '${env.JOB_NAME} [${env.BUILD_NUMBER}]'"
  def summary = "${subject} (${env.BUILD_URL})"

  if (buildStatus == 'STARTED') {
    color = 'YELLOW'
    colorCode = '#FFFF00'
  } else if (buildStatus == 'SUCCESSFUL') {
    color = 'GREEN'
    colorCode = '#00FF00'
  } else {
    color = 'RED'
    colorCode = '#FF0000'
  }

  slackSend (color: , message: )
  slackSend channel: "${slackChannel}", color: "${colorCode}", message: "${summary}", teamDomain: "${slackDomain}", token: "${slackToken}"
}