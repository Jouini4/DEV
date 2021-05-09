/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.shahba.mobile.services;

import com.codename1.components.InfiniteProgress;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.Dialog;
import com.codename1.ui.events.ActionListener;
import com.shahba.mobile.entity.commande;
import com.shahba.mobile.utils.Statics;
import java.util.ArrayList;

/**
 *
 * @author Anis
 */
public class ServiceCommande {
    
     public ArrayList<commande> commande;

    public static ServiceCommande instance = null;

    public boolean resultOk;
    private ConnectionRequest req;

    private ServiceCommande() {req = new ConnectionRequest();}

    public static ServiceCommande getInstance(){
        if(instance == null){
            instance = new ServiceCommande();
        }
        return instance;
    }
    
    public boolean ajouterCommande(commande c ){
        String url = Statics.BASE_URL+"/AjoutercommandeJson";
        InfiniteProgress prog = new InfiniteProgress();
        Dialog d = prog.showInfiniteBlocking();
        req.setDisposeOnCompletion(d);
        req.setUrl(url);
        
        req.addArgument("adresse",c.getAdresse());
        req.addArgument("descriptionAdresse", c.getDescription_adresse());
        req.addArgument("gouvernorat", c.getGouvernorat());
        req.addArgument("codePostal", String.valueOf(c.getCodeP()));
        req.addArgument("numeroTelephone", String.valueOf(c.getTel()));
        req.addArgument("nom", c.getNom());
        req.addArgument("prenom", c.getPrenom());
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOk = req.getResponseCode() == 200;
                req.removeResponseListener(this);
            }
        });
        
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOk;
        
    }
    
}
