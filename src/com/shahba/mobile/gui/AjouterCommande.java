/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.shahba.mobile.gui;

import com.codename1.ui.Container;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;

/**
 *
 * @author Anis
 */
public class AjouterCommande extends Form {
    public AjouterCommande(Resources theme)
    {
        super(new BorderLayout(BorderLayout.CENTER_BEHAVIOR_CENTER_ABSOLUTE));
        Toolbar.setGlobalToolbar(true);
        
        TextField nom = new TextField("", "Nom") ;
        TextField prenom = new TextField("", "Prenom");
        TextField adresse = new TextField("", "Adresse");
        TextField descriptionAdresse = new TextField("", "Description Adresse");
        TextField gouvernorat = new TextField("", "Gouvernorat");
        TextField codeP = new TextField("", "Code Postal");
        TextField numT = new TextField("", "Numéro Téléphone");
        TextField mail = new TextField("", "E-Mail");
        
         Container by = BoxLayout.encloseY(
                 nom,prenom,adresse,descriptionAdresse,gouvernorat,
                 codeP,numT,mail
         );
         
          add(BorderLayout.CENTER, by);
    }
}
