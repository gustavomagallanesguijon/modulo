#! /usr/bin/env python
# -*- coding: utf-8 -*-

#execfile(r"J:\USUARIOS\SISTEM\GMAGALLANES\template\maptemplate.py")
#Se instalo la biblioteca pygresql
# PyGreSQL-4.1.1.win32-py2.6-pg8.4.msi Esta es la version que se instalo, la que funciono. En Python/Arcgis10/  No instalar en otra direccion
# En la actualizacion se instalo: PyGreSQL-4.1.1.win32-py2.7-pg8.4.msi, en el directorio: C:\\Python27\ArcGis10.3  La baje de aqui: http://www.pygresql.org/files/


#############Script que anade una capa mas############
#importamos las bibliotecas necesarias. Comenzamos por la que corresponde a ArcGis
import arcpy

#Esta otra tambien es de ArcGis

from arcpy import env

#Esta corresponde al sistema operativo

import os

#Esta es para la conexion a la base de datos

import pg

#Para procesos

import subprocess

#Biblioteca que se encarga de la manipulacion de imagenes

from PIL import Image
########inicia conexion base de datos y query#################







###########Aqui va la lista de shapes#################3






#ordena la lista de shapes
lista_shapes.sort()


#Se enumera la lista de shapes
for i,j in enumerate(lista_shapes):


#Se imprime 
    print i,j


#ciclo for para ir tomando cada shape de la lista que se definio en lista_shapes
for shapefile in lista_shapes: #si se intenta un shape en particular se anade un rango lista_shapes[45:46]


#divide el nombre del shape tanto en su nombre como en la extension
    filename, file_extension = os.path.splitext(shapefile)


#Convierte el nombre en mayusculas
    filename = filename.upper()


#toma el nombre de la imagen, en funcion de su nombre en mayusculas
    nombreImg = filename[:len(filename)-4]


#intenta
    try:

        
       




        w,h = im.size



    except:



        pass



    consulta = "select nombre from coberturas where cobertura="+"'"+filename+"'"+""







    consulta_escala = "select escala from coberturas where cobertura="+"'"+filename+"'"+""



    consulta_publish = "select publish from coberturas where cobertura="+"'"+filename+"'"+""



    consulta_pubplace = "select pubplace from coberturas where cobertura="+"'"+filename+"'"+""



    consulta_fecha = 'select pubdate from coberturas where cobertura='+"'"+filename+"'"+""
    consulta_cita = "select cita from coberturas where cobertura="+"'"+filename+"'"+""


    consulta_siglas = 'select publish_siglas from coberturas where cobertura='+"'"+filename+"'"+""







    resultado = conn.query(consulta)



    rows = resultado.namedresult()



    titulo_query = rows[0].nombre



    titulo_query = titulo_query.rstrip(".")



    titulo_shapeEstilo = titulo_query.split("(")



    try:



        titulo_shape = "<CLR red='204' green='204' blue='204'><ita>"+titulo_shapeEstilo[0]+"</ita>("+titulo_shapeEstilo[1]+"</CLR>"



    except:



        titulo_shape = "<CLR red='204' green='204' blue='204'><ita>"+titulo_shapeEstilo[0]+"</ita></CLR>"



    cita_shape = "<ita>"+titulo_query+"</ita>"



    titulo_shape = titulo_shape.replace("Distribución potencial", "") #Cambia el primer parametro por el segundo
    titulo_shape = titulo_shape.replace("Registros de presencia", "") #Cambia el primer parametro por el segundo
    titulo_shape = titulo_shape.replace(".", "") #Cambia el primer parametro por el segundo
    resultado_areageo = conn.query(consulta_areageo)
    rows_areageo = resultado_areageo.namedresult()
    areageo_query = rows_areageo[0].areageo
    resultado_escala = conn.query(consulta_escala)
    rows_escala = resultado_escala.namedresult()
    escala_query = rows_escala[0].escala
    resultado_cita = conn.query(consulta_cita)
    rows_cita = resultado_cita.namedresult()
    cita_query = rows_cita[0].cita

    cuenta = 0
    for carac in cita_query:
        if carac == '(':
            cuenta += 1
    if cuenta == 2: #normal
        a = cita_query.find("Distribución")
        titulo_nuevo = cita_query[:a-1]
        subtitulo_nuevo = cita_query[a:]
        b = titulo_nuevo.find("(")
        titulo_normal = titulo_nuevo[:b-1]
        titulo_cursivas = titulo_nuevo[b:]
    else:
        a = cita_query.find("Distribución")
        titulo_cursivas = cita_query[:a-1]
        subtitulo_nuevo = cita_query[a:]
        titulo_normal=""

    subtitulo_nuevo = subtitulo_nuevo.replace("et al", "")
    c = subtitulo_nuevo.find(".")
    subtitulo_1 = subtitulo_nuevo[:c-1]
    subtitulo_2 = subtitulo_nuevo[c:]



    resultado_atributo = conn.query(consulta_atributo)


    rows_atributo = resultado_atributo.namedresult()



    atributo_query = rows_atributo[0].nombre
    
    
    
    resultado_publish = conn.query(consulta_publish)



    rows_publish = resultado_publish.namedresult()



    publish_query = rows_publish[0].publish
    
    
    
    resultado_pubplace = conn.query(consulta_pubplace)



    rows_pubplace = resultado_pubplace.namedresult()



    pubplace_query = rows_pubplace[0].pubplace 

    subtitulo_nuevo = subtitulo_nuevo.replace("et al", "")




    resultado_fecha = conn.query(consulta_fecha)
    rows_fecha = resultado_fecha.namedresult()



    fecha_query = rows_fecha[0].pubdate



    fecha = fecha_query.split('/')



    siglas_id = conn.query(consulta_siglas)


    rows_siglas_id = siglas_id.namedresult()


    siglas_query = rows_siglas_id[0].publish_siglas







    resultado_id = conn.query(autores)



    autores_id = resultado_id.namedresult()



    filename = filename.lower()



####zone for order the list with firt autor in first place



    for indice in autores_id:



        for caracter in indice:



            if caracter[1] != ".":



                autor_principal = indice



                autores_id.index(indice)



                autores_id.remove(indice)



                autores_id.reverse()



                autores_id.append(indice)



                autores_id.reverse()



                break



    if len(autores_id) == 1:



        if autores_id[0].origin.isupper():



            autores_query = autores_id[0].origin



        else:



            separadoXguion_1 = autores_id[0].origin.split("-")



    elif len(autores_id) == 2:



        separadoXguion_1 = autores_id[0].origin.split("-")



        separadoXguion_2 = autores_id[1].origin.split("-")



        autores_query = str(separadoXguion_1[0])+" y "+str(separadoXguion_2[0])



    elif len(autores_id) > 2:



        separadoXguion_1 = autores_id[0].origin.split("-")



        if "," in separadoXguion_1[0]:



            separadoXcoma = separadoXguion_1[0].split(",")



            autores_query = str(separadoXcoma[0])+" <FNT><ita>et al</ita></FNT>"



        else:



            autores_query = str(separadoXguion_1[0])+" <FNT><ita>et al</ita></FNT>"



    else:



        autores_query = siglas_query



    if len(autores_id) == 1:



        separadoXcoma = autores_id[0].origin.split(",")


  
        if len(separadoXcoma) > 1:



            autores_cita_1 = separadoXcoma[0].strip()



            autores_cita_2 = separadoXcoma[1].strip()



            cita = autores_cita_1+", "+autores_cita_2



        if len(separadoXcoma) == 1:



            autores_cita_1 = autores_id[0].origin



            cita = autores_cita_1+"."


            
    elif len(autores_id) > 1:



        separadoXcoma = autores_id[0].origin.split(",")



        separadoXpunto = autores_id[0].origin.split(".")




        if len(separadoXcoma) > 1:



            autores_cita_1 = separadoXcoma[0].strip()



            autores_cita_2 = separadoXcoma[1].strip()



            cita = autores_cita_1+", "+autores_cita_2+", "


  
            i = 1



            autores_cita = ""



            while i<len(autores_id):



                separadoXpunto = autores_id[i].origin.split(".")



                j = 1



                while j<=len(separadoXpunto):



                    autores_cita = autores_cita+ separadoXpunto[j-1]+"."



                    j+=1



                autores_cita = autores_cita.rstrip(".")



                autores_cita = autores_cita+", "



                i+=1



            cita = cita + autores_cita.rstrip(", ")



    elif len(autores_id) == 0:



        cita = siglas_query



    print cita_shape



#Cita para distribución potencial



    if type(escala_query) == type(None):



        cita1 = cita+". "+fecha[2]+". "+cita_shape+", "  



        cita2 = publish_query+", "+pubplace_query+"." 



        cita1+=cita2



#Cita para sitios de recolecta



    else:



        cita1 = cita+". "+fecha[2]+". "+cita_shape+". "   



        cita2 = "escala "+escala_query+". "+publish_query+", "+pubplace_query[0:7]+"."



        cita1+=cita2



    print "Área geográfica: "+areageo_query 



    if areageo_query in ("México y Centroámerica", "México, Centroamérica y Sudamérica", "México, Centroamérica, Sudamérica y El Caribe"):



        mxd = arcpy.mapping.MapDocument(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\baseSeptiembre3GW84.mxd")   #mxds base  distribucion GW84



        mxd_P = arcpy.mapping.MapDocument(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\baseAgostoSR_v3GW84.mxd")   #mxds base sitios de recolecta GW84















    else:



        mxd = arcpy.mapping.MapDocument(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\baseSeptiembre3.mxd")   #mxds base  distribucion



        mxd_P = arcpy.mapping.MapDocument(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\baseAgostoSR_v3.mxd")   #mxds base sitios de recolecta



    df = arcpy.mapping.ListDataFrames(mxd)[0]



    df_P = arcpy.mapping.ListDataFrames(mxd_P)[0]











    print "Trabajando "+desc.file+". Espera por favor." 



    if desc.shapeType == "Polygon":



        if atributo_query == "Value":



            symbologyLayer = (r'J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\color_dp_v.lyr')



        else:







#            symbologyLayer = (r'J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\color_dp.lyr')



        arcpy.ApplySymbologyFromLayer_management(newlayer1, symbologyLayer)



        arcpy.mapping.AddLayer(df, newlayer1, "BOTTOM")



        for capa in arcpy.mapping.ListLayers(mxd, "", df):



            if capa.name == "dest_2010gw": 



                dest_2010gw = capa



            if capa.name == desc.baseName:



                newLayer = capa
        


        arcpy.mapping.MoveLayer(df, dest_2010gw, newLayer,  "AFTER")



        ext = newlayer1.getExtent()



        df.extent = ext



        for elm in arcpy.mapping.ListLayoutElements(mxd, "TEXT_ELEMENT"):



            if elm.text == 'titulo' and cuenta == 2:

                elm.text = "<CLR red='204' green='204' blue='204'><ita>"+titulo_normal+" </ita>"+titulo_cursivas+"</CLR>"
            if elm.text == 'titulo' and cuenta == 1:

                elm.text = "<CLR red='204' green='204' blue='204'><ita>"+titulo_normal+titulo_cursivas+"</ita></CLR>"


        for fechaDp in arcpy.mapping.ListLayoutElements(mxd, "TEXT_ELEMENT"):



            if fechaDp.text == 'subtitulo':




                fechaDp.text = subtitulo_1+"<FNT><ita> et al</ita></FNT>"+subtitulo_2


        for elmPie in arcpy.mapping.ListLayoutElements(mxd, "TEXT_ELEMENT"):



            if elmPie.text == 'cita1':



                elmPie.text = cita1



        try:



            for img in arcpy.mapping.ListLayoutElements(mxd, "PICTURE_ELEMENT"):



                if img.name == "noHayImagen":







                    img.elementPositionX = 0.5082



                    img.elementPositionY = 10.17



                    img.elementWidth = 4.09



                    if h>w:



                        img.elementPositionY = 8.174



                    else:



                        img.elementPositionY = 10.174



                else:



                    print 'Buscando la imagen '+nombreImg+'.JPG'



        except:



            pass











        arcpy.mapping.RemoveLayer(df, newlayer1)



#################################################################################
#                         Comienza la parte de puntos                           #
#################################################################################



    else:







#        symbologyLayer = (r'J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\color_sr.lyr')



        arcpy.ApplySymbologyFromLayer_management(newlayer1, symbologyLayer)



        arcpy.mapping.AddLayer(df_P, newlayer1, "AUTO_ARRANGE")



        for capas in arcpy.mapping.ListLayers(mxd, "", df_P):



            if capas.name == "dest_2010gw": 



                dest_2010 = capas



            if capas.name == desc.baseName:



                nuevaLayer = capas



        arcpy.mapping.MoveLayer(df_P, dest_2010, nuevaLayer,  "AFTER")



        ext = newlayer1.getExtent()



        df_P.extent = ext



        for elm in arcpy.mapping.ListLayoutElements(mxd_P, "TEXT_ELEMENT"):



            if elm.text == 'titulo':



                elm.text = titulo_shape



        for fechaDp in arcpy.mapping.ListLayoutElements(mxd_P, "TEXT_ELEMENT"):



            if fechaDp.text == 'subtitulo':



                fechaDp.text = "Registros de presencia ("+autores_query+". "+fecha[2]+")"



        for elmPie in arcpy.mapping.ListLayoutElements(mxd_P, "TEXT_ELEMENT"):



            if elmPie.text == 'cita1':



                elmPie.text = cita1



        try:



            for img in arcpy.mapping.ListLayoutElements(mxd_P, "PICTURE_ELEMENT"):



                if img.name == "noHayImagen":







                    img.elementPositionX = 0.5082



                    img.elementPositionY = 10.174



                    img.elementWidth = 4.09



                    if h>w:



                        img.elementPositionY = 8.174



                    else:



                        img.elementPositionY = 10.174



                else:



                    print 'Buscando la imagen '+nombreImg+'.JPG'



        except:



            pass











        arcpy.mapping.RemoveLayer(df_P, newlayer1)



################Fin script que anade una capa mas######################



conn.close()
