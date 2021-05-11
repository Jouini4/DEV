/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.shahba.mobile.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import com.shahba.mobile.entity.user;
import com.shahba.mobile.utils.Statics;
import java.io.IOException;
import java.util.Map;

/**
 *
 * @author Anis
 */
public class ServiceUser {
      
    public user u;
    
    
    public static ServiceUser instance = null;

    public boolean resultOk;
    private ConnectionRequest req;

    private ServiceUser() {req = new ConnectionRequest();}

    public static ServiceUser getInstance(){
        if(instance == null){
            instance = new ServiceUser();
        }
        return instance;
    }
    
    public user getUser(int id)
    {   
        String url = Statics.BASE_URL+"/UserJson/"+id;
        req.removeAllArguments();
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                
                
                 try {
                   u = parseUser(new String(req.getResponseData()));
                } catch (IOException ex) {
                    System.out.println(ex.getMessage());
                }
                req.removeResponseListener(this);
            }
             
             
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return u;
    }
    
    public user parseUser(String jsonText) throws IOException
{
    user user;
        JSONParser jp = new JSONParser();
       Map<String, Object> userJson = jp.parseJSON(new CharArrayReader(jsonText.toCharArray()));
       
       
       String nom = userJson.get("username").toString();
       String mail = userJson.get("email").toString();
       String adresse = userJson.get("useraddress").toString();
       int numTel = (int)Float.parseFloat(userJson.get("userphone").toString());
       
       user = new user(mail,nom,numTel,adresse);

       return user;
}
    
}

