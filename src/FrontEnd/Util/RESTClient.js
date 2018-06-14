/**
 * Created by Isaque on 24/07/2017.
 */

function RESTClient()
{
    this.appkey = null;
    this.method = 'POST';
    this.webserviceURL = null;
    this.successCallbackFunction = null;
    this.errorCallbackFunction = null;
    this.dataTypeFormat = 'json';
    this.dataToSender = null;

}
RESTClient.prototype.setAppkey = function(appkey)
{
    this.appkey = appkey;
};
RESTClient.prototype.setMethodGET = function()
{
    this.method = 'GET';
};
RESTClient.prototype.setMethodPOST = function()
{
    this.method = 'POST';
};
RESTClient.prototype.setMethodDELETE = function()
{
    this.method = 'DELETE';
};
RESTClient.prototype.setMethodPUT = function()
{
    this.method = 'PUT';
};
RESTClient.prototype.setWebServiceURL = function(webserviceURL)
{
    this.webserviceURL = webserviceURL;
};
RESTClient.prototype.setSuccessCallbackFunction = function(successCallbackFunction)
{
    this.successCallbackFunction = successCallbackFunction;
};
RESTClient.prototype.setErrorCallbackFunction = function(errorCallbackFunction)
{
    this.errorCallbackFunction = errorCallbackFunction;
};
RESTClient.prototype.setDataTypeFormat = function(dataTypeFormat)
{
    this.dataTypeFormat = dataTypeFormat;
};
RESTClient.prototype.setDataToSender = function(dataToSender)
{
    this.dataToSender = dataToSender;
};
RESTClient.prototype.exec = function()
{
    var sendData;
    if(this.dataToSender != null)
    {
        sendData = JSON.stringify(this.dataToSender);
    }
    $.ajax({
        type: this.method,
        url: this.webserviceURL,
        dataType: this.dataTypeFormat,// data type of response
        data: sendData,
        contentType: "application/json; charset=utf-8",
        traditional: true,
        success: this.successCallbackFunction,
        error: this.errorCallbackFunction
    });
};