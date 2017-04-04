<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/_class/DBConneccion.class.php");

class User extends DBConneccion {

	public function selectEmpresaGrilla($rut_empresa = ""){
		$par = array();
		
		if($rut_empresa != ""){
			$and_rut = "and lower(replace(replace(rut_empresa,'-',''),'.','')) = lower(replace(replace(:rut_empresa,'-',''),'.',''))";
		$par[":rut_empresa"] = array($rut_empresa,-1,SQLT_CHR);
		}

		$sql = "select lower(a.rut_empresa),a.razon_social,b.descripcion,
				       c.nombres||' '||c.apellidos encargado, d.nombre,a.telefono,
				       b.id_direccion,c.id_usuario,d.id_tipo_usuario,
				       a.correo_responsable,a.web
				    from organizacion_nnoc.ORG_EMPRESA a
				left join organizacion_nnoc.ORG_DIRECCION b on (a.id_direccion = b.id_direccion)
				left join organizacion_nnoc.org_usuario c on (a.id_responsable = c.id_usuario)
				left join organizacion_nnoc.ORG_TIPO_USUARIO d on (a.id_tipo_usuario = d.id_tipo_usuario)
				where a.id_estado = 1
				$and_rut
				order by a.razon_social asc";
	return self::consultaNum($sql,$par);
	}

	public function selectUsuario($id_usuario = ""){
		$par = array();

		if($id_usuario != ""){
			$where = "where a.id_usuario = :id_usuario";
		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
		}

		$sql = "SELECT a.ID_USUARIO, a.RUT, a.NOMBRES,
				       a.APELLIDOS, a.TIPO_ROL, a.FECHA_INGRESO,
				       to_char(a.FECHA_RECONOCIMIENTO,'dd/mm/yyyy') FECHA_RECONOCIMIENTO, decode(a.SEXO,'M','MASCULINO','FEMENINO') SEXO, a.EMAIL, 
				       a.LOGIN, a.PASSWD, a.TELEFONO,
				       a.TELEFONO_MOVIL, a.ACTIVO, f.DESC_ZONA zona,
				       a.CODIGO_CIUDAD, a.CODIGO_LOCALIDAD,
				       a.CODIGO_TECNICO, a.NIVEL_APSI, a.ID_CENTRO_COSTO,
				       a.ID_ZONA_CONTABLE, a.ID_DIRECCION, a.INTERNO,
				       a.ID_PERFIL, a.ZONA_OPERACION, a.ID_JEFE,
				       c.nombre cargo, a.FONO_CASA, d.nombre areafun,
				       a.TELEFONO_CASA, a.LOGIN_TANGO, a.LOGIN_EAM,
				       a.CODIGO_TECNICO_TANGO, a.FECHA_NACIMIENTO, a.FECHA_EGRESO,
				       a.PATHFIRMA, a.PATHFOTO, a.DIRECCION_PARTICULAR,
				       a.COMU_PARTICULAR, a.AREA_DIGITALIZACION, a.ACCESO_SIT,
				       k.nombres||' '||k.apellidos creador,a.EMPRESA, B.RAZON_SOCIAL NOMBRE_EMPRESA
				FROM ORGANIZACION_NNOC.V_ORG_USUARIO a
				left join organizacion_nnoc.org_empresa b on (lower(replace(replace(a.empresa,'.',''),'-','')) = lower(replace(replace(b.RUT_EMPRESA,'.',''),'-','')))
				left join organizacion_nnoc.org_cargo c on (a.ID_CARGO = c.id_cargo)
				left join organizacion_nnoc.org_areafun d on(a.id_areafun = d.id_areafun)
				left join organizacion_nnoc.org_perfil e on (a.id_perfil = e.id_perfil)
				left join organizacion_nnoc.org_zona f on (a.cod_zona = f.codi_zona)
				left join organizacion_nnoc.org_direccion g on (a.ID_DIRECCION = g.ID_DIRECCION)
				left join organizacion_nnoc.org_localidad h on (a.CODIGO_LOCALIDAD = h.CODI_LOCALIDAD)
				left join organizacion_nnoc.org_usuario i on(a.id_jefe = i.id_usuario)
				left join organizacion_nnoc.org_localidad j on (a.CODIGO_LOCALIDAD = j.CODI_localidad)
				left join organizacion_nnoc.V_ORG_USUARIO k on (a.id_creador = k.id_usuario)
				$where";

	return self::consultaNum($sql,$par);
	}

	public function selectCargo($and_id_c = ""){
		$par = array();

		if($id_cargo != ""){
			$and_id_c = "where a.id_cargo = :id_cargo";
		$par[":id_cargo"] 	= array($id_cargo,-1,SQLT_INT);
		}

		$sql = "select a.id_cargo,a.nombre,a.descripcion,c.id_tipo_cargo
					   b.nombres||' '||b.apellidos creador,c.nombre
					from organizacion_nnoc.org_cargo a
				left join organizacion_nnoc.org_usuario b on(a.id_creador = b.id_usuario)
				left join organizacion_nnoc.org_tipo_cargo c on(a.id_tipo_cargo = c.id_tipo_cargo)
				$and_id_c
				order by a.nombre asc";

	return self::consultaNum($sql,$par);
	}
}
?>