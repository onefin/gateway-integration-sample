﻿using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Text;
using System.Web;

public enum HttpVerb
{
    GET,
    POST,
    PUT,
    DELETE
}



public class RestClient
{
    public string EndPoint { get; set; }
    public HttpVerb Method { get; set; }
    public string ContentType { get; set; }
    public string PostData { get; set; }

    public RestClient()
    {
        EndPoint = "";
        Method = HttpVerb.GET;
        ContentType = "application/json";
        PostData = "";
    }
    public RestClient(string endpoint)
    {
        EndPoint = endpoint;
        Method = HttpVerb.GET;
        ContentType = "application/json";
        PostData = "";
    }
    public RestClient(string endpoint, HttpVerb method)
    {
        EndPoint = endpoint;
        Method = method;
        ContentType = "application/json";
        PostData = "";
    }

    public RestClient(string endpoint, HttpVerb method, string postData)
    {
        EndPoint = endpoint;
        Method = method;
        ContentType = "application/json";
        PostData = postData;
        ServicePointManager.SecurityProtocol = SecurityProtocolType.Tls
                                                     | SecurityProtocolType.Tls11
                                                     | SecurityProtocolType.Tls12
                                                     | SecurityProtocolType.Ssl3;
    }

    public string MakeRequest()
    {
        try
        {
            var request = (HttpWebRequest)WebRequest.Create(EndPoint);
            request.Method = Method.ToString();
            request.ContentLength = 0;
            request.ContentType = ContentType;

            if (!string.IsNullOrEmpty(PostData) && Method == HttpVerb.POST)
            {
                var encoding = new UTF8Encoding();
                // var bytes = Encoding.GetEncoding("iso-8859-1").GetBytes(PostData);
                var bytes = Encoding.UTF8.GetBytes(PostData);




                request.ContentLength = bytes.Length;

                using (var writeStream = request.GetRequestStream())
                {
                    writeStream.Write(bytes, 0, bytes.Length);
                }
            }

            using (var response = (HttpWebResponse)request.GetResponse())
            {
                var responseValue = string.Empty;

                if (response.StatusCode != HttpStatusCode.OK)
                {
                    var message = String.Format("Request failed. Received HTTP {0}", response.StatusCode);
                    throw new ApplicationException(message);
                }

                // grab the response
                using (var responseStream = response.GetResponseStream())
                {
                    if (responseStream != null)
                        using (var reader = new StreamReader(responseStream))
                        {
                            responseValue = reader.ReadToEnd();
                        }
                }

                return responseValue;
            }
        }
        catch (Exception ex)
        {
            return null;
        }
    }

}