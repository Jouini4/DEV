/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.shahba.mobile.gui;

import com.codename1.components.ImageViewer;
import com.codename1.components.ToastBar;
import com.codename1.components.ToastBar.Status;
import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.Display;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.Toolbar;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;
import com.google.zxing.qrcode.QRCode;
import com.shahba.mobile.entity.commande;
import com.shahba.mobile.entity.livraison;
import com.shahba.mobile.entity.user;
import com.shahba.mobile.services.ServiceLivraison;
import com.shahba.mobile.services.ServiceUser;
import com.wefeel.QRMaker.QRMaker;


/**
 *
 * @author Anis
 */
public class AjouterLivraison extends Form{
    
    
    public AjouterLivraison(Resources theme)
    {
         super(new BorderLayout(BorderLayout.CENTER_BEHAVIOR_CENTER_ABSOLUTE));
        Toolbar.setGlobalToolbar(true);
        
        commande c = ServiceLivraison.getInstance().getLastCommande();
        livraison l = new livraison() ;
        user u = ServiceUser.getInstance().getUser(19);
        
        Label nom = new Label("Nom : "+c.getNom());
        Label prenom = new Label("Prenom : "+c.getPrenom());
        Label adresse = new Label("Adresse : "+c.getAdresse());
        Label numT = new Label("Numero Telephone : "+c.getTel());
        l.setCommande(c);
        Button livraison = new Button("Valider la commande");
        Image i = QRMaker.QRCode(String.valueOf(c.getRef()));
        ImageViewer v = new ImageViewer(i.scaledWidth(Math.round(Display.getInstance().getDisplayWidth() / 2)));
        livraison.addActionListener(new ActionListener() {
             @Override
             public void actionPerformed(ActionEvent evt) {
              ServiceLivraison.getInstance().ajouterLivraison(l);
            Status status = ToastBar.getInstance().createStatus();
            status.setMessage("Merci pour votre confiance");
            status.setShowProgressIndicator(true);
            status.setExpires(30000);
            status.show();
                
                
                 new AjouterCommande(theme).show();
                 
             }
         });
        
        Container by = BoxLayout.encloseY(
                 v,nom,prenom,adresse,numT,livraison
         );
         
          add(BorderLayout.CENTER, by);
    }
   
    
}
