/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.shahba.mobile.gui;

import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;
import com.shahba.mobile.entity.commande;
import com.shahba.mobile.entity.user;
import com.shahba.mobile.services.ServiceCommande;
import com.shahba.mobile.services.ServiceUser;

/**
 *
 * @author Anis
 */
public class AjouterCommande extends Form {
    
    public AjouterCommande(Resources theme)
    {
        
        super(new BorderLayout(BorderLayout.CENTER_BEHAVIOR_CENTER_ABSOLUTE));
        Toolbar.setGlobalToolbar(true);
        
        user u = ServiceUser.getInstance().getUser(19);
        
        TextField nom = new TextField("", "Nom") ;
        TextField prenom = new TextField("", "Prenom");
        TextField adresse = new TextField("", "Adresse");
        TextField descriptionAdresse = new TextField("", "Description Adresse");
        TextField gouvernorat = new TextField("", "Gouvernorat");
        TextField codeP = new TextField("", "Code Postal");
        TextField numT = new TextField("", "Numéro Téléphone");
        TextField mail = new TextField("", "E-Mail");
        
        Button commande = new Button("Passer la commande");
        
        nom.setText(u.getUsername());
        adresse.setText(u.getUseradress());
        mail.setText(u.getEmail());
        numT.setText(String.valueOf(u.getUserphone()));
              
        
        commande.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                commande c = new commande(u, 15, adresse.getText(), descriptionAdresse.getText(), gouvernorat.getText(), Integer.valueOf(codeP.getText()), Integer.valueOf(numT.getText()), nom.getText(), prenom.getText());
                ServiceCommande.getInstance().ajouterCommande(c);
                new AjouterLivraison(theme).show();
            }
        });
        
        
         Container by = BoxLayout.encloseY(
                 nom,prenom,adresse,descriptionAdresse,gouvernorat,
                 codeP,numT,mail,commande
         );
         
          add(BorderLayout.CENTER, by);
    }
}
