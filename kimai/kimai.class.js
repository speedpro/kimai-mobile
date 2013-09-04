/**
 * Kimai - mobile web frontend
 *
 * @version 0.1
 * @author Kevin Papst <kpapst@gmx.net>
 */

/**
 * The global Kimai object gives access to the JSON API.
 */
var Kimai =
{
    apiKey: '',
    jsonApi: '',
    server: null,
    runningEntryId: null,
    logger: null,
    translations: {},

    /**
     * Sets the URL where the JSON API is located.
     *
     * @param string url the url of the json api
     */
    setJsonApi: function(url)
    {
        this.jsonApi = url;
        this.server = jQuery.Zend.jsonrpc({url: url});
    },

    /**
     * Creates a JSON API Call ID.
     * Actually, the API does not care about it yet, we could also use
     * a hardcoded string here, but its better nicer that way...
     *
     * @return string
     */
    getApiCallID: function(apiCall)
    {
        return apiCall; // @TODO improve me
    },

    /**
     * Returns if the current user is authenticated.
     *
     * @return {Boolean}
     */
    isAuthenticated: function()
    {
        return (this.apiKey != '');
    },

    /**
     * Authenticates the user account and returns the API key on success.
     * If user could not be authenticated null will be returned.
     *
     * @param string uid the username
     * @param string pwd the password
     * @return boolean
     */
    authenticate: function(uid, pwd)
    {
        if (this.jsonApi == '' || uid == '' || pwd == '') {
            return false;
        }

        var result = this.server.authenticate(uid, pwd);

        if (typeof result.success != 'undefined' && result.success !== false) {
            this.apiKey = result.items[0].apiKey;
            return true;
        }

        if (typeof result.error.msg != 'undefined') {
            this.error(result.error.msg);
        }

        return false;
    },

    /**
     * Tries to reach the Kimai API and returns true on success.
     *
     * @returns {boolean}
     */
    ping: function()
    {
        if (typeof this.server.error != 'undefined' && this.server.error === true) {
            return false;
        }

        return true;
    },

    /**
     * Retrieve a list ob project objects.
     *
     * @return array
     */
    getProjects: function()
    {
        return this._doApiCall('getProjects');
    },

    /**
     * Returns a list of all tasks for the current user.
     *
     * @return array
     */
    getTasks: function()
    {
        return this._doApiCall('getTasks');
    },

    /**
     * Returns null if no record is processing or an array if one is running.
     *
     * @return null|array
     */
    getRunningTask: function()
    {
        var result = this._doApiCall('getActiveRecording');
        this.debug('getRunningTask', result);

        if (typeof result.error != 'undefined' && typeof result.error.msg != 'undefined') {
            return null;
        }

        if (typeof result[0] == 'undefined') {
            return null;
        }

        result = result[0];

        if (typeof result.activityID != 'undefined') {
            this.runningEntryId = result.timeEntryID;
            return result;
        }

        return null;
    },

    /**
     * Starts the given task within the project.
     *
     * @param integer prjId
     * @param integer taskId
     * @return boolean
     */
    start: function(prjId, taskId)
    {
        var result = this.server.startRecord(this.apiKey, prjId, taskId);

        if (typeof result.success != 'undefined' && result.success !== false) {
            return result.success;
        }

        if (typeof result.error.msg != 'undefined') {
            this.error(result.error.msg);
        }

        return false;
    },

    /**
     * Stops the current running task.
     *
     * @return boolean
     */
    stopRunningTask: function()
    {
        return this.stop(this.runningEntryId);
    },

    /**
     * Stops the given task.
     *
     * @param integer entryId
     * @return boolean
     */
    stop: function(entryId)
    {
        var result = this.server.stopRecord(this.apiKey, entryId);

        if (typeof result.success != 'undefined' && result.success !== false) {
            return result.success;
        }

        if (typeof result.error.msg != 'undefined') {
            this.error(result.error.msg);
        }

        return false;
    },

    /**
     * Calls the JSON Api method and returns the result.
     * This method is only meant for calls with no parameters.
     *
     * @param string apimethod
     * @access private
     * @return mixed
     */
    _doApiCall: function(apimethod)
    {
        var result = this.server[apimethod](this.apiKey);

        if (typeof result.success != 'undefined' && result.success !== false) {
            return result.items;
        }

        if (typeof result.error.msg != 'undefined') {
            this.debug(apimethod, result.error.msg);
        }

        return result;
    },

    /**
     * Sets a logger to use
     *
     * @param object logger
     */
    setLogger: function(logger)
    {
        this.logger = logger;
    },

    /**
     * Show error message.
     *
     * @param string message
     */
    error: function(message)
    {
        if (this.logger !== null) {
            this.logger.error(message);
        }
    },

    /**
     * Show a debug message.
     */
    debug: function(title, value)
    {
        if (this.logger !== null) {
            this.logger.debug(title, value);
        }
    },

    /**
     * Adds a translation string
     *
     * @param name
     * @param msg
     */
    addTranslation: function(name, msg)
    {
        this.translations[name] = msg;
    },

    /**
     * Returns a translation string
     *
     * @param name
     * @return string
     */
    getTranslation: function(name)
    {
        if (typeof this.translations[name] == 'undefined') {
            return name;
        }
        return this.translations[name];
    }
};