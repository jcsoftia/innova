ALTER DATABASE innova_dent SET datestyle = 'iso, dmy';


CREATE OR REPLACE FUNCTION ingresos() RETURNS trigger
AS $$
BEGIN
	UPDATE medicamentos SET stock = stock + NEW.cantidad 
	WHERE medicamentos.id = NEW.idmedicamento;
    UPDATE medicamentos SET precio_venta = NEW.precio 
	WHERE medicamentos.id = NEW.idmedicamento;
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ingresos2() RETURNS trigger
AS $$
BEGIN
	
	 UPDATE medicamentos 
     set stock = stock - detalle_ingresos.cantidad
	 from detalle_ingresos where detalle_ingresos.idmedicamento = medicamentos.id AND detalle_ingresos.idingreso = NEW.id
	;
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ventasAnular() RETURNS trigger
AS $$
BEGIN
	
	 UPDATE medicamentos as me 
     set stock = stock + detalle_ventas.cantidad
	 from detalle_ventas where detalle_ventas.idmedicamento = me.id AND detalle_ventas.idventa = new.id
	;
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE OR REPLACE FUNCTION ventasUpdate() RETURNS trigger
AS $$
BEGIN
	
	 UPDATE medicamentos SET stock = stock - NEW.cantidad 
	WHERE medicamentos.id = NEW.idmedicamento;
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;



CREATE TRIGGER tr_updStockIngreso
AFTER INSERT ON detalle_ingresos
FOR EACH ROW
execute procedure ingresos();

CREATE TRIGGER tr_updStockIngresoAnular
AFTER UPDATE ON ingresos
FOR EACH ROW
execute procedure ingresos2();

CREATE TRIGGER tr_updStockVentas
AFTER INSERT ON detalle_ventas
FOR EACH ROW
execute procedure ventasUpdate();

CREATE TRIGGER tr_updStockVentaAnular
AFTER UPDATE ON ventas
FOR EACH ROW
execute procedure ventasAnular();




