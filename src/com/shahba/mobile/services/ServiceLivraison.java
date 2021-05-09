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
import com.shahba.mobile.entity.commande;
import com.shahba.mobile.utils.Statics;
import java.io.IOException;
import java.util.Map;


/**
 *
 * @author Anis
 */
public class ServiceLivraison {
    public commande lastCommande;
    
    public static ServiceLivraison instance = null;
     public boolean resultOk;
    private ConnectionRequest req;

    public ServiceLivraison() {
        req = new ConnectionRequest();
    }
    
     public static ServiceLivraison getInstance(){
        if(instance == null){
            instance = new ServiceLivraison();
        }
        return instance;
    }
     
    public commande getLastCommande(){
       
        
        String url = Statics.BASE_URL+"/livraisonJson/";
        req.removeAllArguments();
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                try {
                    lastCommande = parseCommande(new String(req.getResponseData()));
                } catch (IOException ex) {
                    System.out.println(ex.getMessage());
                }
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return lastCommande;
    }
    
    
   public commande parseCommande (String jsonText) throws IOException {
       commande c ;
       JSONParser jp = new JSONParser();
       Map<String, Object> commandeJson = jp.parseJSON(new CharArrayReader(jsonText.toCharArray()));
       
       String nom = commandeJson.get("nom").toString();
       String prenom = commandeJson.get("prenom").toString();
       String adresse = commandeJson.get("adresse").toString();
       String descriptionAdresse = commandeJson.get("descriptionAdresse").toString();
       int numeroTelephone = (int)Float.parseFloat(commandeJson.get("numeroTelephone").toString());
           c = new commande(adresse,descriptionAdresse,numeroTelephone,nom,prenom);
   return c ;
   }
    
    
}
