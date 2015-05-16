(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '    <ul>                <li data-name="namespace:Circle" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Circle.html">Circle</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="namespace:Circle_Command" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Circle/Command.html">Command</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="class:Circle_Command_BuildCommand" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Circle/Command/BuildCommand.html">BuildCommand</a>                    </div>                </li>                            <li data-name="class:Circle_Command_CancelCommand" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Circle/Command/CancelCommand.html">CancelCommand</a>                    </div>                </li>                            <li data-name="class:Circle_Command_CommandBase" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Circle/Command/CommandBase.html">CommandBase</a>                    </div>                </li>                            <li data-name="class:Circle_Command_ProgressCommand" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Circle/Command/ProgressCommand.html">ProgressCommand</a>                    </div>                </li>                            <li data-name="class:Circle_Command_ProjectsCommand" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Circle/Command/ProjectsCommand.html">ProjectsCommand</a>                    </div>                </li>                            <li data-name="class:Circle_Command_RetryCommand" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Circle/Command/RetryCommand.html">RetryCommand</a>                    </div>                </li>                            <li data-name="class:Circle_Command_SshKeyCommand" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Circle/Command/SshKeyCommand.html">SshKeyCommand</a>                    </div>                </li>                            <li data-name="class:Circle_Command_StatusCommand" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Circle/Command/StatusCommand.html">StatusCommand</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Circle_Iterator" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Circle/Iterator.html">Iterator</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="class:Circle_Iterator_MapIterator" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Circle/Iterator/MapIterator.html">MapIterator</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Circle_Action" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Circle/Action.html">Action</a>                    </div>                </li>                            <li data-name="class:Circle_Build" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Circle/Build.html">Build</a>                    </div>                </li>                            <li data-name="class:Circle_Circle" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Circle/Circle.html">Circle</a>                    </div>                </li>                            <li data-name="class:Circle_CircleInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Circle/CircleInterface.html">CircleInterface</a>                    </div>                </li>                            <li data-name="class:Circle_Config" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Circle/Config.html">Config</a>                    </div>                </li>                            <li data-name="class:Circle_Project" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Circle/Project.html">Project</a>                    </div>                </li>                            <li data-name="class:Circle_Step" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Circle/Step.html">Step</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    {"type": "Namespace", "link": "Circle.html", "name": "Circle", "doc": "Namespace Circle"},{"type": "Namespace", "link": "Circle/Command.html", "name": "Circle\\Command", "doc": "Namespace Circle\\Command"},{"type": "Namespace", "link": "Circle/Iterator.html", "name": "Circle\\Iterator", "doc": "Namespace Circle\\Iterator"},
            {"type": "Interface", "fromName": "Circle", "fromLink": "Circle.html", "link": "Circle/CircleInterface.html", "name": "Circle\\CircleInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_queryCircle", "name": "Circle\\CircleInterface::queryCircle", "doc": "&quot;Query the Circle API with the given request options.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_getRecentBuilds", "name": "Circle\\CircleInterface::getRecentBuilds", "doc": "&quot;Gets the most recent builds for a project.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_retryBuild", "name": "Circle\\CircleInterface::retryBuild", "doc": "&quot;Retry a previous build.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_cancelBuild", "name": "Circle\\CircleInterface::cancelBuild", "doc": "&quot;Cancel running build.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_getBuild", "name": "Circle\\CircleInterface::getBuild", "doc": "&quot;Gets a build from Circle.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_getAllProjects", "name": "Circle\\CircleInterface::getAllProjects", "doc": "&quot;Gets a list of all projects.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_addSshKey", "name": "Circle\\CircleInterface::addSshKey", "doc": "&quot;Add a new SSH key to a project.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_triggerBuild", "name": "Circle\\CircleInterface::triggerBuild", "doc": "&quot;Trigger a new build on a branch.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_getConfig", "name": "Circle\\CircleInterface::getConfig", "doc": "&quot;Gets the circle configuration object.&quot;"},
            
            
            {"type": "Class", "fromName": "Circle", "fromLink": "Circle.html", "link": "Circle/Action.html", "name": "Circle\\Action", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "Circle\\Action", "fromLink": "Circle/Action.html", "link": "Circle/Action.html#method___construct", "name": "Circle\\Action::__construct", "doc": "&quot;Constructs a new action object.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Action", "fromLink": "Circle/Action.html", "link": "Circle/Action.html#method_getStatus", "name": "Circle\\Action::getStatus", "doc": "&quot;Gets the action status.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Action", "fromLink": "Circle/Action.html", "link": "Circle/Action.html#method_getRunTime", "name": "Circle\\Action::getRunTime", "doc": "&quot;Gets the last run time for this action.&quot;"},
            
            {"type": "Class", "fromName": "Circle", "fromLink": "Circle.html", "link": "Circle/Build.html", "name": "Circle\\Build", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "Circle\\Build", "fromLink": "Circle/Build.html", "link": "Circle/Build.html#method___construct", "name": "Circle\\Build::__construct", "doc": "&quot;Construct a new Circle Build.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Build", "fromLink": "Circle/Build.html", "link": "Circle/Build.html#method_getStatus", "name": "Circle\\Build::getStatus", "doc": "&quot;Gets the current build status.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Build", "fromLink": "Circle/Build.html", "link": "Circle/Build.html#method_getPreviousSuccessfulBuildTime", "name": "Circle\\Build::getPreviousSuccessfulBuildTime", "doc": "&quot;Gets the last successful build time in seconds.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Build", "fromLink": "Circle/Build.html", "link": "Circle/Build.html#method_getPreviousSuccessfulBuildTimeFormatted", "name": "Circle\\Build::getPreviousSuccessfulBuildTimeFormatted", "doc": "&quot;Gets the last successful build formatted as minutes:seconds.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Build", "fromLink": "Circle/Build.html", "link": "Circle/Build.html#method_getStartTime", "name": "Circle\\Build::getStartTime", "doc": "&quot;Gets the build start time as a unix timestamp.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Build", "fromLink": "Circle/Build.html", "link": "Circle/Build.html#method_getLastActionStatus", "name": "Circle\\Build::getLastActionStatus", "doc": "&quot;Gets the very last step, last action&#039;s status.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Build", "fromLink": "Circle/Build.html", "link": "Circle/Build.html#method_getSteps", "name": "Circle\\Build::getSteps", "doc": "&quot;Gets the build steps.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Build", "fromLink": "Circle/Build.html", "link": "Circle/Build.html#method_getLastStep", "name": "Circle\\Build::getLastStep", "doc": "&quot;Gets the last step in the build. This can change if a build is running.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Build", "fromLink": "Circle/Build.html", "link": "Circle/Build.html#method_isFinished", "name": "Circle\\Build::isFinished", "doc": "&quot;Check if our build is finished.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Build", "fromLink": "Circle/Build.html", "link": "Circle/Build.html#method_toArray", "name": "Circle\\Build::toArray", "doc": "&quot;Gets the build as an array.&quot;"},
            
            {"type": "Class", "fromName": "Circle", "fromLink": "Circle.html", "link": "Circle/Circle.html", "name": "Circle\\Circle", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "Circle\\Circle", "fromLink": "Circle/Circle.html", "link": "Circle/Circle.html#method___construct", "name": "Circle\\Circle::__construct", "doc": "&quot;Construct a new Circle service.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Circle", "fromLink": "Circle/Circle.html", "link": "Circle/Circle.html#method_queryCircle", "name": "Circle\\Circle::queryCircle", "doc": "&quot;Query the Circle API with the given request options.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Circle", "fromLink": "Circle/Circle.html", "link": "Circle/Circle.html#method_getRecentBuilds", "name": "Circle\\Circle::getRecentBuilds", "doc": "&quot;Gets the most recent builds for a project.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Circle", "fromLink": "Circle/Circle.html", "link": "Circle/Circle.html#method_retryBuild", "name": "Circle\\Circle::retryBuild", "doc": "&quot;Retry a previous build.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Circle", "fromLink": "Circle/Circle.html", "link": "Circle/Circle.html#method_cancelBuild", "name": "Circle\\Circle::cancelBuild", "doc": "&quot;Cancel running build.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Circle", "fromLink": "Circle/Circle.html", "link": "Circle/Circle.html#method_getBuild", "name": "Circle\\Circle::getBuild", "doc": "&quot;Gets a build from Circle.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Circle", "fromLink": "Circle/Circle.html", "link": "Circle/Circle.html#method_getAllProjects", "name": "Circle\\Circle::getAllProjects", "doc": "&quot;Gets a list of all projects.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Circle", "fromLink": "Circle/Circle.html", "link": "Circle/Circle.html#method_addSshKey", "name": "Circle\\Circle::addSshKey", "doc": "&quot;Add a new SSH key to a project.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Circle", "fromLink": "Circle/Circle.html", "link": "Circle/Circle.html#method_triggerBuild", "name": "Circle\\Circle::triggerBuild", "doc": "&quot;Trigger a new build on a branch.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Circle", "fromLink": "Circle/Circle.html", "link": "Circle/Circle.html#method_getConfig", "name": "Circle\\Circle::getConfig", "doc": "&quot;Gets the circle configuration object.&quot;"},
            
            {"type": "Class", "fromName": "Circle", "fromLink": "Circle.html", "link": "Circle/CircleInterface.html", "name": "Circle\\CircleInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_queryCircle", "name": "Circle\\CircleInterface::queryCircle", "doc": "&quot;Query the Circle API with the given request options.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_getRecentBuilds", "name": "Circle\\CircleInterface::getRecentBuilds", "doc": "&quot;Gets the most recent builds for a project.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_retryBuild", "name": "Circle\\CircleInterface::retryBuild", "doc": "&quot;Retry a previous build.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_cancelBuild", "name": "Circle\\CircleInterface::cancelBuild", "doc": "&quot;Cancel running build.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_getBuild", "name": "Circle\\CircleInterface::getBuild", "doc": "&quot;Gets a build from Circle.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_getAllProjects", "name": "Circle\\CircleInterface::getAllProjects", "doc": "&quot;Gets a list of all projects.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_addSshKey", "name": "Circle\\CircleInterface::addSshKey", "doc": "&quot;Add a new SSH key to a project.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_triggerBuild", "name": "Circle\\CircleInterface::triggerBuild", "doc": "&quot;Trigger a new build on a branch.&quot;"},
                    {"type": "Method", "fromName": "Circle\\CircleInterface", "fromLink": "Circle/CircleInterface.html", "link": "Circle/CircleInterface.html#method_getConfig", "name": "Circle\\CircleInterface::getConfig", "doc": "&quot;Gets the circle configuration object.&quot;"},
            
            {"type": "Class", "fromName": "Circle\\Command", "fromLink": "Circle/Command.html", "link": "Circle/Command/BuildCommand.html", "name": "Circle\\Command\\BuildCommand", "doc": "&quot;This command allows you to trigger a new build on a given branch. using the\n&lt;a href=\&quot;https:\/\/circleci.com\/docs\/api#new-build\&quot;&gt;new build&lt;\/a&gt; endpoint&quot;"},
                    
            {"type": "Class", "fromName": "Circle\\Command", "fromLink": "Circle/Command.html", "link": "Circle/Command/CancelCommand.html", "name": "Circle\\Command\\CancelCommand", "doc": "&quot;This command cancels either the last started build or the build specified via\nthe build-num paramter. This command uses the\n&lt;a href=\&quot;https:\/\/circleci.com\/docs\/api#cancel-build\&quot;&gt;cancel build&lt;\/a&gt; endpoint.&quot;"},
                    
            {"type": "Class", "fromName": "Circle\\Command", "fromLink": "Circle/Command.html", "link": "Circle/Command/CommandBase.html", "name": "Circle\\Command\\CommandBase", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "Circle\\Command\\CommandBase", "fromLink": "Circle/Command/CommandBase.html", "link": "Circle/Command/CommandBase.html#method___construct", "name": "Circle\\Command\\CommandBase::__construct", "doc": "&quot;Constructs a new command object.&quot;"},
            
            {"type": "Class", "fromName": "Circle\\Command", "fromLink": "Circle/Command.html", "link": "Circle/Command/ProgressCommand.html", "name": "Circle\\Command\\ProgressCommand", "doc": "&quot;This command allows you to view the live results of a running build by\npolling the server. The output can be formatted as either a table with all\nthe results or a simple progress bar.&quot;"},
                    
            {"type": "Class", "fromName": "Circle\\Command", "fromLink": "Circle/Command.html", "link": "Circle/Command/ProjectsCommand.html", "name": "Circle\\Command\\ProjectsCommand", "doc": "&quot;This command provides a list of all projects within your Circle CI account\nusing the &lt;a href=\&quot;https:\/\/circleci.com\/docs\/api#projects\&quot;&gt;projects&lt;\/a&gt; endpoint.&quot;"},
                    
            {"type": "Class", "fromName": "Circle\\Command", "fromLink": "Circle/Command.html", "link": "Circle/Command/RetryCommand.html", "name": "Circle\\Command\\RetryCommand", "doc": "&quot;This command starts a \&quot;retry\&quot; of a given build using the\n&lt;a href=\&quot;https:\/\/circleci.com\/docs\/api#retry-build\&quot;&gt;retry-build&lt;\/a&gt; endpoint. You can\nuse \&quot;latest\&quot; to retry the last build and using the \&quot;ssh\&quot; retry-method option\nto rebuild with SSH enabled.&quot;"},
                    
            {"type": "Class", "fromName": "Circle\\Command", "fromLink": "Circle/Command.html", "link": "Circle/Command/SshKeyCommand.html", "name": "Circle\\Command\\SshKeyCommand", "doc": "&quot;This command allows you to add an SSH deploy key to a project using the\n&lt;a href=\&quot;https:\/\/circleci.com\/docs\/api#summary\&quot;&gt;ssh-key&lt;\/a&gt; endpoint.&quot;"},
                    
            {"type": "Class", "fromName": "Circle\\Command", "fromLink": "Circle/Command.html", "link": "Circle/Command/StatusCommand.html", "name": "Circle\\Command\\StatusCommand", "doc": "&quot;This command uses the &lt;a href=\&quot;https:\/\/circleci.com\/docs\/api#recent-builds-project\&quot;&gt;most recent builds&lt;\/a&gt; endpoint\nto provide a quick status overview of the project. The table fields and the\nnumber of results to display is all configurable.&quot;"},
                    
            {"type": "Class", "fromName": "Circle", "fromLink": "Circle.html", "link": "Circle/Config.html", "name": "Circle\\Config", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "Circle\\Config", "fromLink": "Circle/Config.html", "link": "Circle/Config.html#method___construct", "name": "Circle\\Config::__construct", "doc": "&quot;Constructs a new circle config object.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Config", "fromLink": "Circle/Config.html", "link": "Circle/Config.html#method_get", "name": "Circle\\Config::get", "doc": "&quot;Gets the specified config given a key.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Config", "fromLink": "Circle/Config.html", "link": "Circle/Config.html#method_getAll", "name": "Circle\\Config::getAll", "doc": "&quot;Gets the entire config array.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Config", "fromLink": "Circle/Config.html", "link": "Circle/Config.html#method_setAll", "name": "Circle\\Config::setAll", "doc": "&quot;Overwrite the entire loaded config.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Config", "fromLink": "Circle/Config.html", "link": "Circle/Config.html#method_setGlobalFile", "name": "Circle\\Config::setGlobalFile", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "Circle\\Config", "fromLink": "Circle/Config.html", "link": "Circle/Config.html#method_setLocalFile", "name": "Circle\\Config::setLocalFile", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "Circle\\Config", "fromLink": "Circle/Config.html", "link": "Circle/Config.html#method_setPrivateFile", "name": "Circle\\Config::setPrivateFile", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "Circle\\Iterator", "fromLink": "Circle/Iterator.html", "link": "Circle/Iterator/MapIterator.html", "name": "Circle\\Iterator\\MapIterator", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "Circle\\Iterator\\MapIterator", "fromLink": "Circle/Iterator/MapIterator.html", "link": "Circle/Iterator/MapIterator.html#method___construct", "name": "Circle\\Iterator\\MapIterator::__construct", "doc": "&quot;Construct a new MapIterator.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Iterator\\MapIterator", "fromLink": "Circle/Iterator/MapIterator.html", "link": "Circle/Iterator/MapIterator.html#method_current", "name": "Circle\\Iterator\\MapIterator::current", "doc": "&quot;{@inheritdoc}&quot;"},
                    {"type": "Method", "fromName": "Circle\\Iterator\\MapIterator", "fromLink": "Circle/Iterator/MapIterator.html", "link": "Circle/Iterator/MapIterator.html#method_offsetGet", "name": "Circle\\Iterator\\MapIterator::offsetGet", "doc": "&quot;{@inheritdoc}&quot;"},
            
            {"type": "Class", "fromName": "Circle", "fromLink": "Circle.html", "link": "Circle/Project.html", "name": "Circle\\Project", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "Circle\\Project", "fromLink": "Circle/Project.html", "link": "Circle/Project.html#method___construct", "name": "Circle\\Project::__construct", "doc": "&quot;Construct a new Circle Build.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Project", "fromLink": "Circle/Project.html", "link": "Circle/Project.html#method_toArray", "name": "Circle\\Project::toArray", "doc": "&quot;Gets the project as an array.&quot;"},
            
            {"type": "Class", "fromName": "Circle", "fromLink": "Circle.html", "link": "Circle/Step.html", "name": "Circle\\Step", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "Circle\\Step", "fromLink": "Circle/Step.html", "link": "Circle/Step.html#method___construct", "name": "Circle\\Step::__construct", "doc": "&quot;Constructs a new Step.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Step", "fromLink": "Circle/Step.html", "link": "Circle/Step.html#method_getName", "name": "Circle\\Step::getName", "doc": "&quot;Gets the step name.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Step", "fromLink": "Circle/Step.html", "link": "Circle/Step.html#method_getLastAction", "name": "Circle\\Step::getLastAction", "doc": "&quot;Gets the last action in this step.&quot;"},
                    {"type": "Method", "fromName": "Circle\\Step", "fromLink": "Circle/Step.html", "link": "Circle/Step.html#method_isRunning", "name": "Circle\\Step::isRunning", "doc": "&quot;Checks the running status.&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


