--
-- PostgreSQL database dump
--

-- Dumped from database version 14.11 (Ubuntu 14.11-0ubuntu0.22.04.1)
-- Dumped by pg_dump version 14.11 (Ubuntu 14.11-0ubuntu0.22.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: articles; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.articles (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.articles OWNER TO master_db_admin;

--
-- Name: COLUMN articles.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.articles.name IS 'The unique name of the articles';


--
-- Name: COLUMN articles.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.articles.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN articles.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.articles.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN articles.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.articles.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN articles.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.articles.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN articles.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.articles.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: balance_des_comptes; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.balance_des_comptes (
    id uuid NOT NULL,
    solde_debit numeric(12,2) NOT NULL,
    solde_credit numeric(12,2) NOT NULL,
    date_report date NOT NULL,
    date_cloture date,
    balanceable_type character varying(255) NOT NULL,
    balanceable_id uuid NOT NULL,
    exercice_comptable_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.balance_des_comptes OWNER TO master_db_admin;

--
-- Name: COLUMN balance_des_comptes.solde_debit; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.balance_des_comptes.solde_debit IS 'Total debit balance for the account.';


--
-- Name: COLUMN balance_des_comptes.solde_credit; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.balance_des_comptes.solde_credit IS 'Total credit balance for the account.';


--
-- Name: COLUMN balance_des_comptes.date_report; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.balance_des_comptes.date_report IS 'Indicate when the balance date is report';


--
-- Name: COLUMN balance_des_comptes.date_cloture; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.balance_des_comptes.date_cloture IS 'Indicate when the balance date is end up';


--
-- Name: COLUMN balance_des_comptes.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.balance_des_comptes.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN balance_des_comptes.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.balance_des_comptes.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN balance_des_comptes.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.balance_des_comptes.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN balance_des_comptes.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.balance_des_comptes.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN balance_des_comptes.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.balance_des_comptes.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: categories_de_compte; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.categories_de_compte (
    id uuid NOT NULL,
    code character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.categories_de_compte OWNER TO master_db_admin;

--
-- Name: COLUMN categories_de_compte.code; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_de_compte.code IS 'The unique code of the categorie de compte';


--
-- Name: COLUMN categories_de_compte.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_de_compte.name IS 'The unique name of the categorie de compte';


--
-- Name: COLUMN categories_de_compte.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_de_compte.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN categories_de_compte.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_de_compte.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN categories_de_compte.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_de_compte.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN categories_de_compte.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_de_compte.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN categories_de_compte.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_de_compte.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: categories_of_employees; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.categories_of_employees (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    category_id uuid
);


ALTER TABLE public.categories_of_employees OWNER TO master_db_admin;

--
-- Name: COLUMN categories_of_employees.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_of_employees.name IS 'The unique name of the categories_of_employees';


--
-- Name: COLUMN categories_of_employees.description; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_of_employees.description IS 'Description of the category';


--
-- Name: COLUMN categories_of_employees.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_of_employees.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN categories_of_employees.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_of_employees.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN categories_of_employees.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_of_employees.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN categories_of_employees.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_of_employees.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN categories_of_employees.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.categories_of_employees.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: category_of_employee_taux; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.category_of_employee_taux (
    id uuid NOT NULL,
    est_le_taux_de_base boolean DEFAULT false NOT NULL,
    category_of_employee_id uuid NOT NULL,
    taux_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.category_of_employee_taux OWNER TO master_db_admin;

--
-- Name: COLUMN category_of_employee_taux.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.category_of_employee_taux.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN category_of_employee_taux.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.category_of_employee_taux.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN category_of_employee_taux.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.category_of_employee_taux.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN category_of_employee_taux.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.category_of_employee_taux.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN category_of_employee_taux.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.category_of_employee_taux.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: classes_de_compte; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.classes_de_compte (
    id uuid NOT NULL,
    code character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.classes_de_compte OWNER TO master_db_admin;

--
-- Name: COLUMN classes_de_compte.code; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.classes_de_compte.code IS 'The unique code of the classe de compte';


--
-- Name: COLUMN classes_de_compte.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.classes_de_compte.name IS 'The unique name of the classe de compte';


--
-- Name: COLUMN classes_de_compte.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.classes_de_compte.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN classes_de_compte.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.classes_de_compte.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN classes_de_compte.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.classes_de_compte.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN classes_de_compte.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.classes_de_compte.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN classes_de_compte.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.classes_de_compte.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: companies; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.companies (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    registration_number character varying(255),
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.companies OWNER TO master_db_admin;

--
-- Name: COLUMN companies.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.companies.name IS 'Name of the company';


--
-- Name: COLUMN companies.registration_number; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.companies.registration_number IS 'Name of the company';


--
-- Name: COLUMN companies.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.companies.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN companies.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.companies.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN companies.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.companies.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN companies.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.companies.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN companies.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.companies.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: comptes; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.comptes (
    id uuid NOT NULL,
    code character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    type_de_compte character varying(255) DEFAULT 'generale'::character varying NOT NULL,
    categorie_de_compte_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT comptes_type_de_compte_check CHECK (((type_de_compte)::text = ANY ((ARRAY['generale'::character varying, 'analytique'::character varying])::text[])))
);


ALTER TABLE public.comptes OWNER TO master_db_admin;

--
-- Name: COLUMN comptes.code; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.comptes.code IS 'The unique code of the classe de compte';


--
-- Name: COLUMN comptes.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.comptes.name IS 'The unique name of the classe de compte';


--
-- Name: COLUMN comptes.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.comptes.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN comptes.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.comptes.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN comptes.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.comptes.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN comptes.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.comptes.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN comptes.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.comptes.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: contracts; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.contracts (
    id uuid NOT NULL,
    reference character varying(255) NOT NULL,
    type_contract character varying(255) DEFAULT 'cdd'::character varying NOT NULL,
    duree double precision NOT NULL,
    date_debut date NOT NULL,
    date_fin date,
    contract_status character varying(255) DEFAULT 'en_cours'::character varying NOT NULL,
    renouvelable boolean DEFAULT true NOT NULL,
    est_renouveler boolean DEFAULT false NOT NULL,
    poste_id uuid NOT NULL,
    employee_contractuel_id uuid NOT NULL,
    unite_mesures_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    contract_id uuid,
    CONSTRAINT contracts_contract_status_check CHECK (((contract_status)::text = ANY ((ARRAY['en_attente'::character varying, 'en_cours'::character varying, 'terminer'::character varying, 'suspendu'::character varying, 'resilier'::character varying])::text[]))),
    CONSTRAINT contracts_type_contract_check CHECK (((type_contract)::text = ANY ((ARRAY['cdd'::character varying, 'cdi'::character varying, 'alternance'::character varying, 'ctt'::character varying])::text[])))
);


ALTER TABLE public.contracts OWNER TO master_db_admin;

--
-- Name: COLUMN contracts.reference; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contracts.reference IS 'The unique reference of the contracts';


--
-- Name: COLUMN contracts.duree; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contracts.duree IS 'The duration of the contracts';


--
-- Name: COLUMN contracts.date_debut; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contracts.date_debut IS 'Indicate when the contracts was created';


--
-- Name: COLUMN contracts.date_fin; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contracts.date_fin IS 'Indicate when the contracts was created';


--
-- Name: COLUMN contracts.renouvelable; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contracts.renouvelable IS 'Indicate if the contract is renouveble';


--
-- Name: COLUMN contracts.est_renouveler; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contracts.est_renouveler IS 'Indicate if the contract is realy renew';


--
-- Name: COLUMN contracts.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contracts.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN contracts.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contracts.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN contracts.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contracts.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN contracts.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contracts.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN contracts.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contracts.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: contractuelables; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.contractuelables (
    id uuid NOT NULL,
    employee_id uuid NOT NULL,
    contractuelable_type character varying(255) NOT NULL,
    contractuelable_id uuid NOT NULL,
    actif boolean DEFAULT true NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.contractuelables OWNER TO master_db_admin;

--
-- Name: COLUMN contractuelables.actif; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contractuelables.actif IS 'The activity of the employee as contractual or not';


--
-- Name: COLUMN contractuelables.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contractuelables.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN contractuelables.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contractuelables.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN contractuelables.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contractuelables.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN contractuelables.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contractuelables.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN contractuelables.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.contractuelables.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: credentials; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.credentials (
    id uuid NOT NULL,
    identifier character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    user_id uuid NOT NULL,
    created_by uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.credentials OWNER TO master_db_admin;

--
-- Name: COLUMN credentials.identifier; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.credentials.identifier IS 'Encrypted identifier for the user';


--
-- Name: COLUMN credentials.password; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.credentials.password IS 'Encrypted password for the user';


--
-- Name: COLUMN credentials.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.credentials.status IS 'Record status: 
                        - TRUE: Active record or soft delete record
                        - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN credentials.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.credentials.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN credentials.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.credentials.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN credentials.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.credentials.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN credentials.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.credentials.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: departements; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.departements (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.departements OWNER TO master_db_admin;

--
-- Name: COLUMN departements.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.departements.name IS 'The unique name of the departements';


--
-- Name: COLUMN departements.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.departements.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN departements.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.departements.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN departements.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.departements.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN departements.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.departements.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN departements.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.departements.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: devises; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.devises (
    id uuid NOT NULL,
    code character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    symbol character varying(255) NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.devises OWNER TO master_db_admin;

--
-- Name: COLUMN devises.code; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.devises.code IS 'The unique code of the currency';


--
-- Name: COLUMN devises.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.devises.name IS 'The unique name of the currency';


--
-- Name: COLUMN devises.symbol; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.devises.symbol IS 'The unique symbol of the currency';


--
-- Name: COLUMN devises.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.devises.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN devises.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.devises.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN devises.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.devises.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN devises.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.devises.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN devises.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.devises.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: ecritures_comptable; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.ecritures_comptable (
    id uuid NOT NULL,
    libelle character varying(255) NOT NULL,
    date_ecriture date NOT NULL,
    total_debit numeric(12,2) NOT NULL,
    total_credit numeric(12,2) NOT NULL,
    journal_id uuid NOT NULL,
    operation_disponible_id uuid,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.ecritures_comptable OWNER TO master_db_admin;

--
-- Name: COLUMN ecritures_comptable.libelle; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.ecritures_comptable.libelle IS 'Description or label of the accounting entry.';


--
-- Name: COLUMN ecritures_comptable.date_ecriture; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.ecritures_comptable.date_ecriture IS 'Date when the accounting entry is recorded or written.';


--
-- Name: COLUMN ecritures_comptable.total_debit; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.ecritures_comptable.total_debit IS 'Total amount on the debit side.';


--
-- Name: COLUMN ecritures_comptable.total_credit; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.ecritures_comptable.total_credit IS 'Total amount on the credit side.';


--
-- Name: COLUMN ecritures_comptable.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.ecritures_comptable.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN ecritures_comptable.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.ecritures_comptable.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN ecritures_comptable.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.ecritures_comptable.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN ecritures_comptable.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.ecritures_comptable.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN ecritures_comptable.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.ecritures_comptable.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: employee_contractuels; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.employee_contractuels (
    id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.employee_contractuels OWNER TO master_db_admin;

--
-- Name: COLUMN employee_contractuels.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employee_contractuels.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN employee_contractuels.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employee_contractuels.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN employee_contractuels.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employee_contractuels.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN employee_contractuels.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employee_contractuels.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN employee_contractuels.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employee_contractuels.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: employee_non_contractuels; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.employee_non_contractuels (
    id uuid NOT NULL,
    est_convertir boolean DEFAULT false NOT NULL,
    categories_of_employee_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.employee_non_contractuels OWNER TO master_db_admin;

--
-- Name: COLUMN employee_non_contractuels.est_convertir; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employee_non_contractuels.est_convertir IS 'The conversion of the employee to a contractual';


--
-- Name: COLUMN employee_non_contractuels.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employee_non_contractuels.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN employee_non_contractuels.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employee_non_contractuels.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN employee_non_contractuels.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employee_non_contractuels.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN employee_non_contractuels.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employee_non_contractuels.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN employee_non_contractuels.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employee_non_contractuels.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: employees; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.employees (
    id uuid NOT NULL,
    matricule character varying(255) NOT NULL,
    type_employee character varying(255) DEFAULT 'regulier'::character varying NOT NULL,
    statut_employee character varying(255) DEFAULT 'en_service'::character varying NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT employees_statut_employee_check CHECK (((statut_employee)::text = ANY ((ARRAY['en_service'::character varying, 'suspendu'::character varying, 'en_conge'::character varying])::text[]))),
    CONSTRAINT employees_type_employee_check CHECK (((type_employee)::text = ANY ((ARRAY['regulier'::character varying, 'non_regulier'::character varying])::text[])))
);


ALTER TABLE public.employees OWNER TO master_db_admin;

--
-- Name: COLUMN employees.matricule; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employees.matricule IS 'The unique matricule of the employees';


--
-- Name: COLUMN employees.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employees.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN employees.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employees.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN employees.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employees.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN employees.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employees.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN employees.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.employees.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: exercices_comptable; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.exercices_comptable (
    id uuid NOT NULL,
    fiscal_year integer NOT NULL,
    date_ouverture date NOT NULL,
    date_fermeture date,
    status_exercice character varying(255) DEFAULT 'ouvert'::character varying NOT NULL,
    periode_exercice_id uuid NOT NULL,
    plan_comptable_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT exercices_comptable_status_exercice_check CHECK (((status_exercice)::text = ANY ((ARRAY['ouvert'::character varying, 'fermer'::character varying])::text[])))
);


ALTER TABLE public.exercices_comptable OWNER TO master_db_admin;

--
-- Name: COLUMN exercices_comptable.fiscal_year; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.exercices_comptable.fiscal_year IS 'The year of the exerice';


--
-- Name: COLUMN exercices_comptable.date_ouverture; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.exercices_comptable.date_ouverture IS 'Indicate when the exercice start';


--
-- Name: COLUMN exercices_comptable.date_fermeture; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.exercices_comptable.date_fermeture IS 'Indicate when the exercice end up';


--
-- Name: COLUMN exercices_comptable.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.exercices_comptable.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN exercices_comptable.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.exercices_comptable.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN exercices_comptable.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.exercices_comptable.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN exercices_comptable.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.exercices_comptable.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN exercices_comptable.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.exercices_comptable.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: journaux; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.journaux (
    id uuid NOT NULL,
    total numeric(12,2) NOT NULL,
    total_debit numeric(12,2) NOT NULL,
    total_credit numeric(12,2) NOT NULL,
    exercice_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.journaux OWNER TO master_db_admin;

--
-- Name: COLUMN journaux.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.journaux.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN journaux.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.journaux.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN journaux.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.journaux.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN journaux.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.journaux.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN journaux.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.journaux.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: lignes_ecriture_comptable; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.lignes_ecriture_comptable (
    id uuid NOT NULL,
    libelle character varying(255),
    type_ecriture_compte character varying(255) DEFAULT 'debit'::character varying NOT NULL,
    montant numeric(12,2) NOT NULL,
    accountable_type character varying(255) NOT NULL,
    accountable_id uuid NOT NULL,
    ligneable_type character varying(255) NOT NULL,
    ligneable_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT lignes_ecriture_comptable_type_ecriture_compte_check CHECK (((type_ecriture_compte)::text = ANY ((ARRAY['debit'::character varying, 'credit'::character varying])::text[])))
);


ALTER TABLE public.lignes_ecriture_comptable OWNER TO master_db_admin;

--
-- Name: COLUMN lignes_ecriture_comptable.libelle; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.lignes_ecriture_comptable.libelle IS 'Libelle of the ecriture comptable';


--
-- Name: COLUMN lignes_ecriture_comptable.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.lignes_ecriture_comptable.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN lignes_ecriture_comptable.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.lignes_ecriture_comptable.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN lignes_ecriture_comptable.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.lignes_ecriture_comptable.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN lignes_ecriture_comptable.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.lignes_ecriture_comptable.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN lignes_ecriture_comptable.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.lignes_ecriture_comptable.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO master_db_admin;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: master_db_admin
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO master_db_admin;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: master_db_admin
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: montants; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.montants (
    id uuid NOT NULL,
    montant numeric(8,2) NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.montants OWNER TO master_db_admin;

--
-- Name: COLUMN montants.montant; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.montants.montant IS 'The monetary amount associated with the "montants" entry';


--
-- Name: COLUMN montants.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.montants.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN montants.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.montants.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN montants.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.montants.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN montants.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.montants.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN montants.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.montants.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: non_contractuel_categories; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.non_contractuel_categories (
    id uuid NOT NULL,
    date_debut date NOT NULL,
    date_fin date,
    employee_non_contractuel_id uuid NOT NULL,
    categories_of_employee_id uuid NOT NULL,
    category_of_employee_taux_id uuid,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.non_contractuel_categories OWNER TO master_db_admin;

--
-- Name: COLUMN non_contractuel_categories.date_debut; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.non_contractuel_categories.date_debut IS 'Indicate when the contract was created';


--
-- Name: COLUMN non_contractuel_categories.date_fin; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.non_contractuel_categories.date_fin IS 'Indicate when the contract was created';


--
-- Name: COLUMN non_contractuel_categories.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.non_contractuel_categories.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN non_contractuel_categories.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.non_contractuel_categories.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN non_contractuel_categories.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.non_contractuel_categories.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN non_contractuel_categories.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.non_contractuel_categories.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN non_contractuel_categories.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.non_contractuel_categories.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: oauth_access_tokens; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.oauth_access_tokens (
    id character varying(100) NOT NULL,
    user_id uuid,
    client_id uuid NOT NULL,
    name character varying(255),
    scopes text,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    status boolean DEFAULT true NOT NULL,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_access_tokens OWNER TO master_db_admin;

--
-- Name: COLUMN oauth_access_tokens.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_access_tokens.status IS 'Record status: 
                    - TRUE: Active record or soft delete record
                    - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN oauth_access_tokens.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_access_tokens.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: oauth_auth_codes; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.oauth_auth_codes (
    id character varying(100) NOT NULL,
    user_id uuid NOT NULL,
    client_id uuid NOT NULL,
    scopes text,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone,
    status boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_auth_codes OWNER TO master_db_admin;

--
-- Name: COLUMN oauth_auth_codes.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_auth_codes.status IS 'Record status: 
                    - TRUE: Active record or soft delete record
                    - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN oauth_auth_codes.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_auth_codes.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN oauth_auth_codes.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_auth_codes.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN oauth_auth_codes.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_auth_codes.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: oauth_clients; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.oauth_clients (
    id uuid NOT NULL,
    user_id uuid,
    name character varying(255) NOT NULL,
    secret character varying(100),
    provider character varying(255),
    redirect text NOT NULL,
    personal_access_client boolean NOT NULL,
    password_client boolean NOT NULL,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    status boolean DEFAULT true NOT NULL,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_clients OWNER TO master_db_admin;

--
-- Name: COLUMN oauth_clients.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_clients.status IS 'Record status: 
                    - TRUE: Active record or soft delete record
                    - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN oauth_clients.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_clients.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: oauth_personal_access_clients; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.oauth_personal_access_clients (
    id bigint NOT NULL,
    client_id uuid NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    status boolean DEFAULT true NOT NULL,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_personal_access_clients OWNER TO master_db_admin;

--
-- Name: COLUMN oauth_personal_access_clients.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_personal_access_clients.status IS 'Record status: 
                    - TRUE: Active record or soft delete record
                    - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN oauth_personal_access_clients.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_personal_access_clients.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE; Schema: public; Owner: master_db_admin
--

CREATE SEQUENCE public.oauth_personal_access_clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.oauth_personal_access_clients_id_seq OWNER TO master_db_admin;

--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: master_db_admin
--

ALTER SEQUENCE public.oauth_personal_access_clients_id_seq OWNED BY public.oauth_personal_access_clients.id;


--
-- Name: oauth_refresh_tokens; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.oauth_refresh_tokens (
    id character varying(100) NOT NULL,
    access_token_id character varying(100) NOT NULL,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone,
    status boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_refresh_tokens OWNER TO master_db_admin;

--
-- Name: COLUMN oauth_refresh_tokens.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_refresh_tokens.status IS 'Record status: 
                    - TRUE: Active record or soft delete record
                    - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN oauth_refresh_tokens.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_refresh_tokens.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN oauth_refresh_tokens.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_refresh_tokens.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN oauth_refresh_tokens.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.oauth_refresh_tokens.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: operations_comptable; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.operations_comptable (
    id uuid NOT NULL,
    libelle character varying(255) NOT NULL,
    date_ecriture date NOT NULL,
    total_debit numeric(12,2) NOT NULL,
    total_credit numeric(12,2) NOT NULL,
    status_operation character varying(255) DEFAULT 'en_attente'::character varying NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT operations_comptable_status_operation_check CHECK (((status_operation)::text = ANY ((ARRAY['en_attente'::character varying, 'valider'::character varying, 'rejeter'::character varying])::text[])))
);


ALTER TABLE public.operations_comptable OWNER TO master_db_admin;

--
-- Name: COLUMN operations_comptable.libelle; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.operations_comptable.libelle IS 'Description or label of the accounting entry.';


--
-- Name: COLUMN operations_comptable.date_ecriture; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.operations_comptable.date_ecriture IS 'Date when the accounting entry is recorded or written.';


--
-- Name: COLUMN operations_comptable.total_debit; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.operations_comptable.total_debit IS 'Total debit amount for the account.';


--
-- Name: COLUMN operations_comptable.total_credit; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.operations_comptable.total_credit IS 'Total credit amount for the account.';


--
-- Name: COLUMN operations_comptable.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.operations_comptable.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN operations_comptable.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.operations_comptable.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN operations_comptable.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.operations_comptable.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN operations_comptable.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.operations_comptable.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN operations_comptable.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.operations_comptable.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: people; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.people (
    id uuid NOT NULL,
    last_name character varying(255) NOT NULL,
    first_name character varying(255) NOT NULL,
    middle_name jsonb DEFAULT '[]'::jsonb NOT NULL,
    sex character varying(255) DEFAULT 'unknown'::character varying NOT NULL,
    marital_status character varying(255) DEFAULT 'single'::character varying NOT NULL,
    birth_date date,
    nip bigint,
    ifu bigint,
    nationality character varying(255),
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT people_marital_status_check CHECK (((marital_status)::text = ANY ((ARRAY['single'::character varying, 'married'::character varying, 'divorced'::character varying, 'widowed'::character varying])::text[]))),
    CONSTRAINT people_sex_check CHECK (((sex)::text = ANY ((ARRAY['male'::character varying, 'female'::character varying, 'unknown'::character varying])::text[])))
);


ALTER TABLE public.people OWNER TO master_db_admin;

--
-- Name: COLUMN people.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.people.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN people.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.people.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN people.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.people.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN people.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.people.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN people.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.people.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: periodes_exercice; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.periodes_exercice (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    date_debut_periode date NOT NULL,
    date_fin_periode date NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.periodes_exercice OWNER TO master_db_admin;

--
-- Name: COLUMN periodes_exercice.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.periodes_exercice.name IS 'The unique name of the periode name';


--
-- Name: COLUMN periodes_exercice.date_debut_periode; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.periodes_exercice.date_debut_periode IS 'Indicate when an exercice comptable should start';


--
-- Name: COLUMN periodes_exercice.date_fin_periode; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.periodes_exercice.date_fin_periode IS 'Indicate when an exercice comptable will end';


--
-- Name: COLUMN periodes_exercice.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.periodes_exercice.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN periodes_exercice.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.periodes_exercice.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN periodes_exercice.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.periodes_exercice.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN periodes_exercice.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.periodes_exercice.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN periodes_exercice.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.periodes_exercice.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: permissions; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.permissions (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    key character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO master_db_admin;

--
-- Name: COLUMN permissions.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.permissions.name IS 'Unique name of the permission';


--
-- Name: COLUMN permissions.key; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.permissions.key IS 'Unique key of the permission';


--
-- Name: COLUMN permissions.slug; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.permissions.slug IS 'Unique slug of the permission';


--
-- Name: COLUMN permissions.description; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.permissions.description IS 'Description of the permission';


--
-- Name: COLUMN permissions.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.permissions.status IS 'Record status:
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN permissions.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.permissions.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN permissions.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.permissions.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN permissions.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.permissions.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN permissions.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.permissions.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO master_db_admin;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: master_db_admin
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO master_db_admin;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: master_db_admin
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: plan_comptable_compte_sous_comptes; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.plan_comptable_compte_sous_comptes (
    id uuid NOT NULL,
    account_number character varying(255) NOT NULL,
    account_id uuid NOT NULL,
    sous_compte_id uuid NOT NULL,
    sub_division_id uuid,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.plan_comptable_compte_sous_comptes OWNER TO master_db_admin;

--
-- Name: COLUMN plan_comptable_compte_sous_comptes.account_number; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_compte_sous_comptes.account_number IS 'The unique account number';


--
-- Name: COLUMN plan_comptable_compte_sous_comptes.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_compte_sous_comptes.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN plan_comptable_compte_sous_comptes.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_compte_sous_comptes.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN plan_comptable_compte_sous_comptes.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_compte_sous_comptes.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN plan_comptable_compte_sous_comptes.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_compte_sous_comptes.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN plan_comptable_compte_sous_comptes.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_compte_sous_comptes.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: plan_comptable_comptes; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.plan_comptable_comptes (
    id uuid NOT NULL,
    account_number character varying(255) NOT NULL,
    classe_id uuid NOT NULL,
    plan_comptable_id uuid NOT NULL,
    compte_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.plan_comptable_comptes OWNER TO master_db_admin;

--
-- Name: COLUMN plan_comptable_comptes.account_number; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_comptes.account_number IS 'The unique account number';


--
-- Name: COLUMN plan_comptable_comptes.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_comptes.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN plan_comptable_comptes.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_comptes.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN plan_comptable_comptes.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_comptes.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN plan_comptable_comptes.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_comptes.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN plan_comptable_comptes.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plan_comptable_comptes.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: plans_comptable; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.plans_comptable (
    id uuid NOT NULL,
    code character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.plans_comptable OWNER TO master_db_admin;

--
-- Name: COLUMN plans_comptable.code; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plans_comptable.code IS 'The unique code of the plan comptable';


--
-- Name: COLUMN plans_comptable.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plans_comptable.name IS 'The unique name of the plan comptable';


--
-- Name: COLUMN plans_comptable.description; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plans_comptable.description IS 'Description of the plan comptable';


--
-- Name: COLUMN plans_comptable.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plans_comptable.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN plans_comptable.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plans_comptable.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN plans_comptable.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plans_comptable.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN plans_comptable.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plans_comptable.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN plans_comptable.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.plans_comptable.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: poste_salaries; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.poste_salaries (
    id uuid NOT NULL,
    est_le_salaire_de_base boolean DEFAULT false NOT NULL,
    poste_id uuid NOT NULL,
    salary_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.poste_salaries OWNER TO master_db_admin;

--
-- Name: COLUMN poste_salaries.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.poste_salaries.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN poste_salaries.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.poste_salaries.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN poste_salaries.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.poste_salaries.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN poste_salaries.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.poste_salaries.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN poste_salaries.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.poste_salaries.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: postes; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.postes (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    department_id uuid NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.postes OWNER TO master_db_admin;

--
-- Name: COLUMN postes.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.postes.name IS 'The unique name of the postes';


--
-- Name: COLUMN postes.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.postes.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN postes.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.postes.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN postes.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.postes.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN postes.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.postes.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN postes.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.postes.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: role_has_permissions; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.role_has_permissions (
    id uuid NOT NULL,
    role_id uuid NOT NULL,
    permission_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_detach boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.role_has_permissions OWNER TO master_db_admin;

--
-- Name: COLUMN role_has_permissions.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.role_has_permissions.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN role_has_permissions.can_be_detach; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.role_has_permissions.can_be_detach IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN role_has_permissions.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.role_has_permissions.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN role_has_permissions.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.role_has_permissions.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN role_has_permissions.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.role_has_permissions.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: roles; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.roles (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    key character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    created_by uuid
);


ALTER TABLE public.roles OWNER TO master_db_admin;

--
-- Name: COLUMN roles.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.roles.name IS 'The unique name of the role';


--
-- Name: COLUMN roles.key; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.roles.key IS 'The unique key of the role';


--
-- Name: COLUMN roles.slug; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.roles.slug IS 'The unique slug of the role';


--
-- Name: COLUMN roles.description; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.roles.description IS 'Description of the role';


--
-- Name: COLUMN roles.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.roles.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN roles.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.roles.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN roles.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.roles.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN roles.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.roles.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN roles.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.roles.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: salaires; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.salaires (
    id uuid NOT NULL,
    montant numeric(10,2) NOT NULL,
    date_debut date NOT NULL,
    date_fin date,
    est_valide boolean DEFAULT true NOT NULL,
    contract_id uuid NOT NULL,
    poste_salarie_id uuid,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.salaires OWNER TO master_db_admin;

--
-- Name: COLUMN salaires.date_debut; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.salaires.date_debut IS 'Indicate when the contract was created';


--
-- Name: COLUMN salaires.date_fin; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.salaires.date_fin IS 'Indicate when the contract was created';


--
-- Name: COLUMN salaires.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.salaires.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN salaires.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.salaires.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN salaires.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.salaires.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN salaires.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.salaires.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN salaires.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.salaires.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: taux_and_salaries; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.taux_and_salaries (
    id uuid NOT NULL,
    montant_id uuid NOT NULL,
    unite_mesure_id uuid,
    hint numeric(8,2) NOT NULL,
    unite_travaille_id uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.taux_and_salaries OWNER TO master_db_admin;

--
-- Name: COLUMN taux_and_salaries.hint; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.taux_and_salaries.hint IS 'The hint of the taux';


--
-- Name: COLUMN taux_and_salaries.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.taux_and_salaries.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN taux_and_salaries.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.taux_and_salaries.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN taux_and_salaries.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.taux_and_salaries.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN taux_and_salaries.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.taux_and_salaries.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN taux_and_salaries.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.taux_and_salaries.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: unite_mesures; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.unite_mesures (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    symbol character varying(255) NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.unite_mesures OWNER TO master_db_admin;

--
-- Name: COLUMN unite_mesures.name; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_mesures.name IS 'The unique name of the unite_mesure';


--
-- Name: COLUMN unite_mesures.symbol; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_mesures.symbol IS 'The symbol of the unite_mesure';


--
-- Name: COLUMN unite_mesures.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_mesures.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN unite_mesures.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_mesures.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN unite_mesures.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_mesures.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN unite_mesures.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_mesures.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN unite_mesures.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_mesures.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: unite_travailles; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.unite_travailles (
    id uuid NOT NULL,
    type_of_unite_travaille character varying(255) DEFAULT 'article'::character varying NOT NULL,
    unite_mesure_id uuid NOT NULL,
    article_id uuid,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    created_by uuid NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT unite_travailles_type_of_unite_travaille_check CHECK (((type_of_unite_travaille)::text = ANY ((ARRAY['article'::character varying, 'temps'::character varying])::text[])))
);


ALTER TABLE public.unite_travailles OWNER TO master_db_admin;

--
-- Name: COLUMN unite_travailles.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_travailles.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN unite_travailles.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_travailles.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN unite_travailles.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_travailles.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN unite_travailles.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_travailles.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN unite_travailles.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.unite_travailles.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: user_has_roles; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.user_has_roles (
    id uuid NOT NULL,
    user_id uuid NOT NULL,
    role_id uuid NOT NULL,
    attached_by uuid NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_detach boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.user_has_roles OWNER TO master_db_admin;

--
-- Name: COLUMN user_has_roles.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.user_has_roles.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN user_has_roles.can_be_detach; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.user_has_roles.can_be_detach IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN user_has_roles.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.user_has_roles.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN user_has_roles.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.user_has_roles.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN user_has_roles.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.user_has_roles.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: users; Type: TABLE; Schema: public; Owner: master_db_admin
--

CREATE TABLE public.users (
    id uuid NOT NULL,
    type_of_account character varying(255) DEFAULT 'personal'::character varying NOT NULL,
    username character varying(255),
    login_channel character varying(255) DEFAULT 'email'::character varying NOT NULL,
    phone_number jsonb NOT NULL,
    address jsonb,
    email character varying(255),
    userable_type character varying(255) NOT NULL,
    userable_id uuid NOT NULL,
    profilable_type character varying(255),
    profilable_id uuid,
    email_verified_at timestamp(0) without time zone,
    email_verified boolean DEFAULT false NOT NULL,
    account_activated boolean DEFAULT false NOT NULL,
    account_activated_at timestamp(0) without time zone,
    account_verified boolean DEFAULT false NOT NULL,
    account_verified_at timestamp(0) without time zone,
    email_verification_token character varying(255),
    first_login boolean DEFAULT true NOT NULL,
    status boolean DEFAULT true NOT NULL,
    can_be_delete boolean DEFAULT true NOT NULL,
    account_status character varying(255) DEFAULT 'pending_activation'::character varying NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    created_by uuid NOT NULL,
    CONSTRAINT users_account_status_check CHECK (((account_status)::text = ANY ((ARRAY['pending_activation'::character varying, 'pending_verification'::character varying, 'pending_password_reset'::character varying, 'active'::character varying, 'suspended'::character varying, 'disabled'::character varying, 'closed'::character varying, 'inactive'::character varying, 'banned'::character varying, 'locked'::character varying])::text[]))),
    CONSTRAINT users_login_channel_check CHECK (((login_channel)::text = ANY ((ARRAY['email'::character varying, 'phone_number'::character varying])::text[]))),
    CONSTRAINT users_type_of_account_check CHECK (((type_of_account)::text = ANY ((ARRAY['personal'::character varying, 'moral'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO master_db_admin;

--
-- Name: COLUMN users.username; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.username IS 'The unique username of the user';


--
-- Name: COLUMN users.phone_number; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.phone_number IS 'The phone number of the user';


--
-- Name: COLUMN users.address; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.address IS 'Address of the user';


--
-- Name: COLUMN users.email; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.email IS 'Email address of the user';


--
-- Name: COLUMN users.email_verified_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.email_verified_at IS 'Timestamp of email verification';


--
-- Name: COLUMN users.email_verified; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.email_verified IS 'Email verification status';


--
-- Name: COLUMN users.account_activated; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.account_activated IS 'Account activation status';


--
-- Name: COLUMN users.account_activated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.account_activated_at IS 'Timestamp of account activation';


--
-- Name: COLUMN users.account_verified; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.account_verified IS 'Account verification status';


--
-- Name: COLUMN users.account_verified_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.account_verified_at IS 'Timestamp of account verification';


--
-- Name: COLUMN users.email_verification_token; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.email_verification_token IS 'Token for email verification';


--
-- Name: COLUMN users.first_login; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.first_login IS 'First connexion';


--
-- Name: COLUMN users.status; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.status IS 'Record status: 
                            - TRUE: Active record or soft delete record
                            - FALSE: permanently Deleted and can be archived in another datastore';


--
-- Name: COLUMN users.can_be_delete; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.can_be_delete IS 'Flag indicating whether the record can be deleted';


--
-- Name: COLUMN users.created_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.created_at IS 'Timestamp indicating when the record was created';


--
-- Name: COLUMN users.updated_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.updated_at IS 'Timestamp indicating the last update of the record';


--
-- Name: COLUMN users.deleted_at; Type: COMMENT; Schema: public; Owner: master_db_admin
--

COMMENT ON COLUMN public.users.deleted_at IS 'Soft delete column for marking records as deleted without permanent removal';


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: oauth_personal_access_clients id; Type: DEFAULT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.oauth_personal_access_clients ALTER COLUMN id SET DEFAULT nextval('public.oauth_personal_access_clients_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Data for Name: articles; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.articles (id, name, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: balance_des_comptes; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.balance_des_comptes (id, solde_debit, solde_credit, date_report, date_cloture, balanceable_type, balanceable_id, exercice_comptable_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: categories_de_compte; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.categories_de_compte (id, code, name, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: categories_of_employees; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.categories_of_employees (id, name, description, status, can_be_delete, created_by, created_at, updated_at, deleted_at, category_id) FROM stdin;
\.


--
-- Data for Name: category_of_employee_taux; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.category_of_employee_taux (id, est_le_taux_de_base, category_of_employee_id, taux_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: classes_de_compte; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.classes_de_compte (id, code, name, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: companies; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.companies (id, name, registration_number, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
9b8a1335-91d9-4cf0-8e91-3ca9600d99a4	Osinski - Bergstrom	\N	t	t	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	2024-03-11 16:08:20	2024-03-11 16:08:20	\N
\.


--
-- Data for Name: comptes; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.comptes (id, code, name, type_de_compte, categorie_de_compte_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: contracts; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.contracts (id, reference, type_contract, duree, date_debut, date_fin, contract_status, renouvelable, est_renouveler, poste_id, employee_contractuel_id, unite_mesures_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at, contract_id) FROM stdin;
\.


--
-- Data for Name: contractuelables; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.contractuelables (id, employee_id, contractuelable_type, contractuelable_id, actif, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: credentials; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.credentials (id, identifier, password, user_id, created_by, status, can_be_delete, created_at, updated_at, deleted_at) FROM stdin;
9b8a079b-2e70-4ae7-9a8a-6a3ee958655b	johndoe@gmail.com	$2y$12$qZuZenxisvTINcLSQqtQF.mNOUHr1RqfunKkl..iNxn7qjNSqjpRW	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	t	t	2024-03-11 15:35:54	2024-03-11 15:35:54	\N
\.


--
-- Data for Name: departements; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.departements (id, name, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
9b8a079b-5416-448a-a55d-85bca5841a20	production	t	t	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	2024-03-11 15:35:54	2024-03-11 15:35:54	\N
9b8a079b-59c9-4d8e-b2fd-c8e7580cfa48	finance	t	t	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	2024-03-11 15:35:54	2024-03-11 15:35:54	\N
9b8a079b-600f-4325-8b12-3edecc797b70	vente	t	t	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	2024-03-11 15:35:54	2024-03-11 15:35:54	\N
\.


--
-- Data for Name: devises; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.devises (id, code, name, symbol, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: ecritures_comptable; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.ecritures_comptable (id, libelle, date_ecriture, total_debit, total_credit, journal_id, operation_disponible_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: employee_contractuels; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.employee_contractuels (id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: employee_non_contractuels; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.employee_non_contractuels (id, est_convertir, categories_of_employee_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: employees; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.employees (id, matricule, type_employee, statut_employee, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: exercices_comptable; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.exercices_comptable (id, fiscal_year, date_ouverture, date_fermeture, status_exercice, periode_exercice_id, plan_comptable_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: journaux; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.journaux (id, total, total_debit, total_credit, exercice_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: lignes_ecriture_comptable; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.lignes_ecriture_comptable (id, libelle, type_ecriture_compte, montant, accountable_type, accountable_id, ligneable_type, ligneable_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2016_06_01_000001_create_oauth_auth_codes_table	1
2	2016_06_01_000002_create_oauth_access_tokens_table	1
3	2016_06_01_000003_create_oauth_refresh_tokens_table	1
4	2016_06_01_000004_create_oauth_clients_table	1
5	2016_06_01_000005_create_oauth_personal_access_clients_table	1
6	2019_12_14_000001_create_personal_access_tokens_table	1
7	2024_02_29_145920_create_permissions_table	1
8	2024_02_29_145925_create_roles_table	1
9	2024_02_29_145937_create_role_has_permissions_table	1
10	2024_02_29_150003_create_users_table	1
11	2024_02_29_150017_create_people_table	1
12	2024_02_29_150024_create_companies_table	1
13	2024_02_29_150030_create_credentials_table	1
14	2024_03_04_022358_create_user_has_roles_table	1
15	2024_03_05_143455_create_articles_table	1
16	2024_03_05_150547_create_unite_mesures_table	1
17	2024_03_05_150620_create_unite_travailles_table	1
18	2024_03_05_160539_create_departements_table	1
19	2024_03_05_165304_create_postes_table	1
20	2024_03_06_034927_create_categories_of_employees_table	1
21	2024_03_06_160654_create_employees_table	1
22	2024_03_07_053825_create_montants_table	1
23	2024_03_07_053849_create_taux_and_salaries_table	1
24	2024_03_07_055329_create_category_of_employee_taux_table	1
25	2024_03_07_060144_create_poste_salaries_table	1
26	2024_03_07_195248_create_contractuelables_table	1
27	2024_03_07_200823_create_employee_contractuels_table	1
28	2024_03_07_200835_create_employee_non_contractuels_table	1
29	2024_03_07_202233_create_contracts_table	1
30	2024_03_07_205743_create_salaires_table	1
31	2024_03_07_212241_create_non_contractuel_categories_table	1
32	2024_03_08_085433_create_devises_table	1
33	2024_03_08_085548_create_periodes_exercice_table	1
34	2024_03_08_085720_create_plans_comptable_table	1
35	2024_03_08_085756_create_categories_de_compte_table	1
36	2024_03_08_085812_create_classes_de_compte_table	1
37	2024_03_08_085814_create_comptes_table	1
38	2024_03_08_095315_create_plan_comptable_comptes_table	1
39	2024_03_08_100412_create_plan_comptable_compte_sous_comptes_table	1
40	2024_03_08_100904_create_exercices_comptable_table	1
41	2024_03_08_101639_create_balance_des_comptes_table	1
42	2024_03_08_104620_create_journaux_table	1
43	2024_03_08_105855_create_operations_comptable_table	1
44	2024_03_08_105912_create_ecritures_comptable_table	1
45	2024_03_08_111350_create_lignes_ecriture_comptable_table	1
46	2024_06_01_121929_add_new_columns_to_tables	1
\.


--
-- Data for Name: montants; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.montants (id, montant, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: non_contractuel_categories; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.non_contractuel_categories (id, date_debut, date_fin, employee_non_contractuel_id, categories_of_employee_id, category_of_employee_taux_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: oauth_access_tokens; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.oauth_access_tokens (id, user_id, client_id, name, scopes, revoked, created_at, updated_at, expires_at, status, deleted_at) FROM stdin;
\.


--
-- Data for Name: oauth_auth_codes; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.oauth_auth_codes (id, user_id, client_id, scopes, revoked, expires_at, status, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: oauth_clients; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.oauth_clients (id, user_id, name, secret, provider, redirect, personal_access_client, password_client, revoked, created_at, updated_at, status, deleted_at) FROM stdin;
9b8a079b-31bb-4f46-8b98-0811716e31bb	9b8a079b-2e70-4ae7-9a8a-6a3ee958655b	Password Grant 	a9c9a65ec046acc3e47c1d77f72b2cbbe6ad443ba24017dd74d86e4183887ad0	\N	http://localhost	f	t	f	2024-03-11 15:35:54	2024-03-11 15:35:54	t	\N
9b8a07a3-18e8-4cc6-b09b-2c64608995f2	\N	Laravel Personal Access Client	R82nwU8ZiI8daGz7RDfbhvb80WiNKbdaBhnLNf6P	\N	http://localhost	t	f	f	2024-03-11 15:35:59	2024-03-11 15:35:59	t	\N
9b8a07a3-300a-4e59-9977-973648ee1d4a	\N	Laravel Password Grant Client	68Ck6kTzIRAbZPkIhq14U1ocDB7a3ZhQcvAsJYFq	users	http://localhost	f	t	f	2024-03-11 15:35:59	2024-03-11 15:35:59	t	\N
\.


--
-- Data for Name: oauth_personal_access_clients; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.oauth_personal_access_clients (id, client_id, created_at, updated_at, status, deleted_at) FROM stdin;
1	9b8a07a3-18e8-4cc6-b09b-2c64608995f2	2024-03-11 15:35:59	2024-03-11 15:35:59	t	\N
\.


--
-- Data for Name: oauth_refresh_tokens; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.oauth_refresh_tokens (id, access_token_id, revoked, expires_at, status, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: operations_comptable; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.operations_comptable (id, libelle, date_ecriture, total_debit, total_credit, status_operation, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: people; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.people (id, last_name, first_name, middle_name, sex, marital_status, birth_date, nip, ifu, nationality, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
9b8a079a-725e-4530-822e-e95ff4652012	DOE	john	["Phillipe"]	male	single	\N	\N	\N	\N	t	t	\N	2024-03-11 15:35:53	2024-03-11 15:35:53	\N
\.


--
-- Data for Name: periodes_exercice; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.periodes_exercice (id, name, date_debut_periode, date_fin_periode, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.permissions (id, name, key, slug, description, status, can_be_delete, created_at, updated_at, deleted_at) FROM stdin;
9b8a079a-1a92-4c72-8db7-7a50c6936311	View Users	view_users	view-users	Permission to view users	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N
9b8a079a-2dd7-45fe-a7d2-8f9ed5daab1a	Create Users	create_users	create-users	Permission to create new users	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N
9b8a079a-32d8-4ca6-adb4-39411464fcac	Edit Users	edit_users	edit-users	Permission to edit existing users	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N
9b8a079a-36d1-4421-89c4-de8f290df370	Delete Users	delete_users	delete-users	Permission to delete users	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N
9b8a079a-3a8a-4251-b68a-2d9c103a3507	View Roles	view_roles	view-roles	Permission to view roles	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N
9b8a079a-3e92-4a54-b7ce-dca4ec4bb71d	Edit Roles	edit_roles	edit-roles	Permission to edit roles	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N
9b8a079a-431b-4f5c-87aa-7233b5ba9c5d	Delete Roles	delete_roles	delete-roles	Permission to delete roles	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N
9b8a079a-472f-4ba6-b224-8dc3d1d9a61d	View Permissions	view_permissions	view-permissions	Permission to view permissions	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N
9b8a079a-4b70-4d00-88d3-51f8c79dce8b	Edit Permissions	edit_permissions	edit-permissions	Permission to edit permissions	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N
9b8a079a-5021-40c5-b01a-d00f3f8c0a10	Delete Permissions	delete_permissions	delete-permissions	Permission to delete permissions	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: plan_comptable_compte_sous_comptes; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.plan_comptable_compte_sous_comptes (id, account_number, account_id, sous_compte_id, sub_division_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: plan_comptable_comptes; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.plan_comptable_comptes (id, account_number, classe_id, plan_comptable_id, compte_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: plans_comptable; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.plans_comptable (id, code, name, description, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: poste_salaries; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.poste_salaries (id, est_le_salaire_de_base, poste_id, salary_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: postes; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.postes (id, name, status, can_be_delete, department_id, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: role_has_permissions; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.role_has_permissions (id, role_id, permission_id, status, can_be_detach, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.roles (id, name, key, slug, description, status, can_be_delete, created_at, updated_at, deleted_at, created_by) FROM stdin;
9b8a079a-56b3-4e8a-9ecf-d78333823ad2	super administrateur	super_administrateur	super-administrateur	Super Administrator Role	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N	\N
9b8a079a-5bfe-4175-a05c-b5dab4f5cce3	administrateur	administrateur	administrateur	Role	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N	\N
9b8a079a-63e5-46e9-88f0-66cc3f0aa891	employer	employer	Employer	Role	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N	\N
9b8a079a-6a39-4800-b0c1-8051b47baab5	partenaire	partenaire	partenaire	Role	t	f	2024-03-11 15:35:53	2024-03-11 15:35:53	\N	\N
\.


--
-- Data for Name: salaires; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.salaires (id, montant, date_debut, date_fin, est_valide, contract_id, poste_salarie_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: taux_and_salaries; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.taux_and_salaries (id, montant_id, unite_mesure_id, hint, unite_travaille_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: unite_mesures; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.unite_mesures (id, name, symbol, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
9b8a079b-37d1-4f1c-9eae-22cd63215119	mois	m	t	t	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	2024-03-11 15:35:54	2024-03-11 15:35:54	\N
9b8a079b-42d8-458e-ab7f-a2154a55e1dd	jour	j	t	t	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	2024-03-11 15:35:54	2024-03-11 15:35:54	\N
9b8a079b-4c5b-49eb-a0b6-82c65d08f70f	heure	h	t	t	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	2024-03-11 15:35:54	2024-03-11 15:35:54	\N
\.


--
-- Data for Name: unite_travailles; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.unite_travailles (id, type_of_unite_travaille, unite_mesure_id, article_id, status, can_be_delete, created_by, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: user_has_roles; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.user_has_roles (id, user_id, role_id, attached_by, status, can_be_detach, created_at, updated_at, deleted_at) FROM stdin;
9b8a079a-8e97-4a9b-b5ae-72603b250ce0	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	9b8a079a-56b3-4e8a-9ecf-d78333823ad2	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	t	f	2024-03-11 08:35:54	\N	\N
9b8a1335-b154-438c-9920-f3227cfbd964	9b8a1335-9e9a-4dc4-bd2d-ee8e0deaefbc	9b8a079a-56b3-4e8a-9ecf-d78333823ad2	9b8a079a-7900-456f-a0bc-65caaa6c7ea4	t	f	2024-03-11 09:08:21	\N	\N
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: master_db_admin
--

COPY public.users (id, type_of_account, username, login_channel, phone_number, address, email, userable_type, userable_id, profilable_type, profilable_id, email_verified_at, email_verified, account_activated, account_activated_at, account_verified, account_verified_at, email_verification_token, first_login, status, can_be_delete, account_status, created_at, updated_at, deleted_at, created_by) FROM stdin;
9b8a079a-7900-456f-a0bc-65caaa6c7ea4	personal	doe.john	email	{"number": 87321067, "area_code": null, "country_code": 229}	\N	johndoe@gmail.com	App\\Models\\Person	9b8a079a-725e-4530-822e-e95ff4652012	\N	\N	\N	f	f	\N	f	\N	\N	t	t	t	pending_activation	2024-03-11 15:35:53	2024-03-11 15:35:53	\N	9b8a079a-7900-456f-a0bc-65caaa6c7ea4
9b8a1335-9e9a-4dc4-bd2d-ee8e0deaefbc	moral	osinskibergstrom	email	{"number": 804262261, "area_code": null, "country_code": 224}	\N	doe3gh@gmail.com	App\\Models\\Company	9b8a1335-91d9-4cf0-8e91-3ca9600d99a4	\N	\N	\N	f	f	\N	f	\N	\N	t	t	t	pending_activation	2024-03-11 16:08:20	2024-03-11 16:08:20	\N	9b8a079a-7900-456f-a0bc-65caaa6c7ea4
\.


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: master_db_admin
--

SELECT pg_catalog.setval('public.migrations_id_seq', 46, true);


--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: master_db_admin
--

SELECT pg_catalog.setval('public.oauth_personal_access_clients_id_seq', 1, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: master_db_admin
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: articles articles_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_name_unique UNIQUE (name);


--
-- Name: articles articles_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_pkey PRIMARY KEY (id);


--
-- Name: balance_des_comptes balance_des_comptes_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.balance_des_comptes
    ADD CONSTRAINT balance_des_comptes_pkey PRIMARY KEY (id);


--
-- Name: categories_de_compte categories_de_compte_code_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.categories_de_compte
    ADD CONSTRAINT categories_de_compte_code_unique UNIQUE (code);


--
-- Name: categories_de_compte categories_de_compte_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.categories_de_compte
    ADD CONSTRAINT categories_de_compte_name_unique UNIQUE (name);


--
-- Name: categories_de_compte categories_de_compte_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.categories_de_compte
    ADD CONSTRAINT categories_de_compte_pkey PRIMARY KEY (id);


--
-- Name: categories_of_employees categories_of_employees_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.categories_of_employees
    ADD CONSTRAINT categories_of_employees_name_unique UNIQUE (name);


--
-- Name: categories_of_employees categories_of_employees_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.categories_of_employees
    ADD CONSTRAINT categories_of_employees_pkey PRIMARY KEY (id);


--
-- Name: category_of_employee_taux category_of_employee_taux_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.category_of_employee_taux
    ADD CONSTRAINT category_of_employee_taux_pkey PRIMARY KEY (id);


--
-- Name: classes_de_compte classes_de_compte_code_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.classes_de_compte
    ADD CONSTRAINT classes_de_compte_code_unique UNIQUE (code);


--
-- Name: classes_de_compte classes_de_compte_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.classes_de_compte
    ADD CONSTRAINT classes_de_compte_name_unique UNIQUE (name);


--
-- Name: classes_de_compte classes_de_compte_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.classes_de_compte
    ADD CONSTRAINT classes_de_compte_pkey PRIMARY KEY (id);


--
-- Name: companies companies_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_pkey PRIMARY KEY (id);


--
-- Name: companies companies_registration_number_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_registration_number_unique UNIQUE (registration_number);


--
-- Name: comptes comptes_code_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.comptes
    ADD CONSTRAINT comptes_code_unique UNIQUE (code);


--
-- Name: comptes comptes_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.comptes
    ADD CONSTRAINT comptes_name_unique UNIQUE (name);


--
-- Name: comptes comptes_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.comptes
    ADD CONSTRAINT comptes_pkey PRIMARY KEY (id);


--
-- Name: contracts contracts_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.contracts
    ADD CONSTRAINT contracts_pkey PRIMARY KEY (id);


--
-- Name: contracts contracts_reference_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.contracts
    ADD CONSTRAINT contracts_reference_unique UNIQUE (reference);


--
-- Name: contractuelables contractuelables_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.contractuelables
    ADD CONSTRAINT contractuelables_pkey PRIMARY KEY (id);


--
-- Name: credentials credentials_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.credentials
    ADD CONSTRAINT credentials_pkey PRIMARY KEY (id);


--
-- Name: departements departements_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.departements
    ADD CONSTRAINT departements_name_unique UNIQUE (name);


--
-- Name: departements departements_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.departements
    ADD CONSTRAINT departements_pkey PRIMARY KEY (id);


--
-- Name: devises devises_code_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.devises
    ADD CONSTRAINT devises_code_unique UNIQUE (code);


--
-- Name: devises devises_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.devises
    ADD CONSTRAINT devises_name_unique UNIQUE (name);


--
-- Name: devises devises_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.devises
    ADD CONSTRAINT devises_pkey PRIMARY KEY (id);


--
-- Name: devises devises_symbol_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.devises
    ADD CONSTRAINT devises_symbol_unique UNIQUE (symbol);


--
-- Name: ecritures_comptable ecritures_comptable_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.ecritures_comptable
    ADD CONSTRAINT ecritures_comptable_pkey PRIMARY KEY (id);


--
-- Name: employee_contractuels employee_contractuels_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.employee_contractuels
    ADD CONSTRAINT employee_contractuels_pkey PRIMARY KEY (id);


--
-- Name: employee_non_contractuels employee_non_contractuels_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.employee_non_contractuels
    ADD CONSTRAINT employee_non_contractuels_pkey PRIMARY KEY (id);


--
-- Name: employees employees_matricule_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_matricule_unique UNIQUE (matricule);


--
-- Name: employees employees_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_pkey PRIMARY KEY (id);


--
-- Name: exercices_comptable exercices_comptable_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.exercices_comptable
    ADD CONSTRAINT exercices_comptable_pkey PRIMARY KEY (id);


--
-- Name: journaux journaux_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.journaux
    ADD CONSTRAINT journaux_pkey PRIMARY KEY (id);


--
-- Name: lignes_ecriture_comptable lignes_ecriture_comptable_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.lignes_ecriture_comptable
    ADD CONSTRAINT lignes_ecriture_comptable_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: montants montants_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.montants
    ADD CONSTRAINT montants_pkey PRIMARY KEY (id);


--
-- Name: non_contractuel_categories non_contractuel_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.non_contractuel_categories
    ADD CONSTRAINT non_contractuel_categories_pkey PRIMARY KEY (id);


--
-- Name: oauth_access_tokens oauth_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.oauth_access_tokens
    ADD CONSTRAINT oauth_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: oauth_auth_codes oauth_auth_codes_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.oauth_auth_codes
    ADD CONSTRAINT oauth_auth_codes_pkey PRIMARY KEY (id);


--
-- Name: oauth_clients oauth_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.oauth_clients
    ADD CONSTRAINT oauth_clients_pkey PRIMARY KEY (id);


--
-- Name: oauth_personal_access_clients oauth_personal_access_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.oauth_personal_access_clients
    ADD CONSTRAINT oauth_personal_access_clients_pkey PRIMARY KEY (id);


--
-- Name: oauth_refresh_tokens oauth_refresh_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.oauth_refresh_tokens
    ADD CONSTRAINT oauth_refresh_tokens_pkey PRIMARY KEY (id);


--
-- Name: operations_comptable operations_comptable_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.operations_comptable
    ADD CONSTRAINT operations_comptable_pkey PRIMARY KEY (id);


--
-- Name: people people_ifu_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.people
    ADD CONSTRAINT people_ifu_unique UNIQUE (ifu);


--
-- Name: people people_nip_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.people
    ADD CONSTRAINT people_nip_unique UNIQUE (nip);


--
-- Name: people people_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.people
    ADD CONSTRAINT people_pkey PRIMARY KEY (id);


--
-- Name: periodes_exercice periodes_exercice_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.periodes_exercice
    ADD CONSTRAINT periodes_exercice_name_unique UNIQUE (name);


--
-- Name: periodes_exercice periodes_exercice_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.periodes_exercice
    ADD CONSTRAINT periodes_exercice_pkey PRIMARY KEY (id);


--
-- Name: permissions permissions_key_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_key_unique UNIQUE (key);


--
-- Name: permissions permissions_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_unique UNIQUE (name);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- Name: permissions permissions_slug_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_slug_unique UNIQUE (slug);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: plan_comptable_compte_sous_comptes plan_comptable_compte_sous_comptes_account_number_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_compte_sous_comptes
    ADD CONSTRAINT plan_comptable_compte_sous_comptes_account_number_unique UNIQUE (account_number);


--
-- Name: plan_comptable_compte_sous_comptes plan_comptable_compte_sous_comptes_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_compte_sous_comptes
    ADD CONSTRAINT plan_comptable_compte_sous_comptes_pkey PRIMARY KEY (id);


--
-- Name: plan_comptable_comptes plan_comptable_comptes_account_number_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_comptes
    ADD CONSTRAINT plan_comptable_comptes_account_number_unique UNIQUE (account_number);


--
-- Name: plan_comptable_comptes plan_comptable_comptes_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_comptes
    ADD CONSTRAINT plan_comptable_comptes_pkey PRIMARY KEY (id);


--
-- Name: plans_comptable plans_comptable_code_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plans_comptable
    ADD CONSTRAINT plans_comptable_code_unique UNIQUE (code);


--
-- Name: plans_comptable plans_comptable_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plans_comptable
    ADD CONSTRAINT plans_comptable_name_unique UNIQUE (name);


--
-- Name: plans_comptable plans_comptable_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plans_comptable
    ADD CONSTRAINT plans_comptable_pkey PRIMARY KEY (id);


--
-- Name: poste_salaries poste_salaries_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.poste_salaries
    ADD CONSTRAINT poste_salaries_pkey PRIMARY KEY (id);


--
-- Name: postes postes_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.postes
    ADD CONSTRAINT postes_name_unique UNIQUE (name);


--
-- Name: postes postes_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.postes
    ADD CONSTRAINT postes_pkey PRIMARY KEY (id);


--
-- Name: role_has_permissions role_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_pkey PRIMARY KEY (id);


--
-- Name: roles roles_key_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_key_unique UNIQUE (key);


--
-- Name: roles roles_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_unique UNIQUE (name);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: roles roles_slug_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_slug_unique UNIQUE (slug);


--
-- Name: salaires salaires_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.salaires
    ADD CONSTRAINT salaires_pkey PRIMARY KEY (id);


--
-- Name: taux_and_salaries taux_and_salaries_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.taux_and_salaries
    ADD CONSTRAINT taux_and_salaries_pkey PRIMARY KEY (id);


--
-- Name: unite_mesures unite_mesures_name_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.unite_mesures
    ADD CONSTRAINT unite_mesures_name_unique UNIQUE (name);


--
-- Name: unite_mesures unite_mesures_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.unite_mesures
    ADD CONSTRAINT unite_mesures_pkey PRIMARY KEY (id);


--
-- Name: unite_travailles unite_travailles_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.unite_travailles
    ADD CONSTRAINT unite_travailles_pkey PRIMARY KEY (id);


--
-- Name: user_has_roles user_has_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.user_has_roles
    ADD CONSTRAINT user_has_roles_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_phone_number_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_phone_number_unique UNIQUE (phone_number);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users users_username_unique; Type: CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_unique UNIQUE (username);


--
-- Name: articles_name_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX articles_name_status_can_be_delete_index ON public.articles USING btree (name, status, can_be_delete);


--
-- Name: balance_des_comptes_balanceable_type_balanceable_id_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX balance_des_comptes_balanceable_type_balanceable_id_index ON public.balance_des_comptes USING btree (balanceable_type, balanceable_id);


--
-- Name: balance_des_comptes_solde_debit_solde_credit_date_report_date_c; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX balance_des_comptes_solde_debit_solde_credit_date_report_date_c ON public.balance_des_comptes USING btree (solde_debit, solde_credit, date_report, date_cloture, status, can_be_delete);


--
-- Name: categories_de_compte_code_name_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX categories_de_compte_code_name_status_can_be_delete_index ON public.categories_de_compte USING btree (code, name, status, can_be_delete);


--
-- Name: categories_of_employees_name_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX categories_of_employees_name_status_can_be_delete_index ON public.categories_of_employees USING btree (name, status, can_be_delete);


--
-- Name: category_of_employee_taux_est_le_taux_de_base_status_can_be_del; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX category_of_employee_taux_est_le_taux_de_base_status_can_be_del ON public.category_of_employee_taux USING btree (est_le_taux_de_base, status, can_be_delete);


--
-- Name: classes_de_compte_code_name_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX classes_de_compte_code_name_status_can_be_delete_index ON public.classes_de_compte USING btree (code, name, status, can_be_delete);


--
-- Name: companies_name_created_by_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX companies_name_created_by_status_can_be_delete_index ON public.companies USING btree (name, created_by, status, can_be_delete);


--
-- Name: comptes_code_name_type_de_compte_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX comptes_code_name_type_de_compte_status_can_be_delete_index ON public.comptes USING btree (code, name, type_de_compte, status, can_be_delete);


--
-- Name: contracts_reference_type_contract_contract_status_status_can_be; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX contracts_reference_type_contract_contract_status_status_can_be ON public.contracts USING btree (reference, type_contract, contract_status, status, can_be_delete);


--
-- Name: contractuelables_contractuelable_type_contractuelable_id_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX contractuelables_contractuelable_type_contractuelable_id_index ON public.contractuelables USING btree (contractuelable_type, contractuelable_id);


--
-- Name: contractuelables_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX contractuelables_status_can_be_delete_index ON public.contractuelables USING btree (status, can_be_delete);


--
-- Name: departements_name_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX departements_name_status_can_be_delete_index ON public.departements USING btree (name, status, can_be_delete);


--
-- Name: devises_code_name_symbol_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX devises_code_name_symbol_status_can_be_delete_index ON public.devises USING btree (code, name, symbol, status, can_be_delete);


--
-- Name: ecritures_comptable_date_ecriture_total_debit_total_credit_stat; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX ecritures_comptable_date_ecriture_total_debit_total_credit_stat ON public.ecritures_comptable USING btree (date_ecriture, total_debit, total_credit, status, can_be_delete);


--
-- Name: employee_contractuels_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX employee_contractuels_status_can_be_delete_index ON public.employee_contractuels USING btree (status, can_be_delete);


--
-- Name: employee_non_contractuels_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX employee_non_contractuels_status_can_be_delete_index ON public.employee_non_contractuels USING btree (status, can_be_delete);


--
-- Name: employees_matricule_type_employee_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX employees_matricule_type_employee_status_can_be_delete_index ON public.employees USING btree (matricule, type_employee, status, can_be_delete);


--
-- Name: exercices_comptable_fiscal_year_date_ouverture_date_fermeture_s; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX exercices_comptable_fiscal_year_date_ouverture_date_fermeture_s ON public.exercices_comptable USING btree (fiscal_year, date_ouverture, date_fermeture, status_exercice, status, can_be_delete);


--
-- Name: journaux_total_total_debit_total_credit_status_can_be_delete_in; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX journaux_total_total_debit_total_credit_status_can_be_delete_in ON public.journaux USING btree (total, total_debit, total_credit, status, can_be_delete);


--
-- Name: lignes_ecriture_comptable_accountable_type_accountable_id_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX lignes_ecriture_comptable_accountable_type_accountable_id_index ON public.lignes_ecriture_comptable USING btree (accountable_type, accountable_id);


--
-- Name: lignes_ecriture_comptable_ligneable_type_ligneable_id_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX lignes_ecriture_comptable_ligneable_type_ligneable_id_index ON public.lignes_ecriture_comptable USING btree (ligneable_type, ligneable_id);


--
-- Name: lignes_ecriture_comptable_montant_ligneable_id_ligneable_type_s; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX lignes_ecriture_comptable_montant_ligneable_id_ligneable_type_s ON public.lignes_ecriture_comptable USING btree (montant, ligneable_id, ligneable_type, status, can_be_delete);


--
-- Name: montants_montant_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX montants_montant_status_can_be_delete_index ON public.montants USING btree (montant, status, can_be_delete);


--
-- Name: non_contractuel_categories_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX non_contractuel_categories_status_can_be_delete_index ON public.non_contractuel_categories USING btree (status, can_be_delete);


--
-- Name: oauth_access_tokens_user_id_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX oauth_access_tokens_user_id_index ON public.oauth_access_tokens USING btree (user_id);


--
-- Name: oauth_auth_codes_user_id_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX oauth_auth_codes_user_id_index ON public.oauth_auth_codes USING btree (user_id);


--
-- Name: oauth_clients_user_id_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX oauth_clients_user_id_index ON public.oauth_clients USING btree (user_id);


--
-- Name: oauth_refresh_tokens_access_token_id_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX oauth_refresh_tokens_access_token_id_index ON public.oauth_refresh_tokens USING btree (access_token_id);


--
-- Name: operations_comptable_date_ecriture_total_debit_total_credit_sta; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX operations_comptable_date_ecriture_total_debit_total_credit_sta ON public.operations_comptable USING btree (date_ecriture, total_debit, total_credit, status, can_be_delete);


--
-- Name: people_last_name_first_name_middle_name_sex_marital_status_crea; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX people_last_name_first_name_middle_name_sex_marital_status_crea ON public.people USING btree (last_name, first_name, middle_name, sex, marital_status, created_by, status, can_be_delete);


--
-- Name: periodes_exercice_name_date_debut_periode_date_fin_periode_stat; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX periodes_exercice_name_date_debut_periode_date_fin_periode_stat ON public.periodes_exercice USING btree (name, date_debut_periode, date_fin_periode, status, can_be_delete);


--
-- Name: permissions_name_slug_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX permissions_name_slug_status_can_be_delete_index ON public.permissions USING btree (name, slug, status, can_be_delete);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: plan_comptable_compte_sous_comptes_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX plan_comptable_compte_sous_comptes_status_can_be_delete_index ON public.plan_comptable_compte_sous_comptes USING btree (status, can_be_delete);


--
-- Name: plan_comptable_comptes_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX plan_comptable_comptes_status_can_be_delete_index ON public.plan_comptable_comptes USING btree (status, can_be_delete);


--
-- Name: plans_comptable_code_name_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX plans_comptable_code_name_status_can_be_delete_index ON public.plans_comptable USING btree (code, name, status, can_be_delete);


--
-- Name: poste_salaries_est_le_salaire_de_base_status_can_be_delete_inde; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX poste_salaries_est_le_salaire_de_base_status_can_be_delete_inde ON public.poste_salaries USING btree (est_le_salaire_de_base, status, can_be_delete);


--
-- Name: postes_name_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX postes_name_status_can_be_delete_index ON public.postes USING btree (name, status, can_be_delete);


--
-- Name: role_has_permissions_role_id_permission_id_status_can_be_detach; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX role_has_permissions_role_id_permission_id_status_can_be_detach ON public.role_has_permissions USING btree (role_id, permission_id, status, can_be_detach);


--
-- Name: roles_created_by_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX roles_created_by_index ON public.roles USING btree (created_by);


--
-- Name: roles_name_slug_key_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX roles_name_slug_key_status_can_be_delete_index ON public.roles USING btree (name, slug, key, status, can_be_delete);


--
-- Name: salaires_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX salaires_status_can_be_delete_index ON public.salaires USING btree (status, can_be_delete);


--
-- Name: taux_and_salaries_montant_id_unite_travaille_id_hint_status_can; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX taux_and_salaries_montant_id_unite_travaille_id_hint_status_can ON public.taux_and_salaries USING btree (montant_id, unite_travaille_id, hint, status, can_be_delete);


--
-- Name: unite_mesures_name_status_can_be_delete_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX unite_mesures_name_status_can_be_delete_index ON public.unite_mesures USING btree (name, status, can_be_delete);


--
-- Name: unite_travailles_type_of_unite_travaille_unite_mesure_id_status; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX unite_travailles_type_of_unite_travaille_unite_mesure_id_status ON public.unite_travailles USING btree (type_of_unite_travaille, unite_mesure_id, status, can_be_delete);


--
-- Name: user_has_roles_user_id_role_id_status_can_be_detach_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX user_has_roles_user_id_role_id_status_can_be_detach_index ON public.user_has_roles USING btree (user_id, role_id, status, can_be_detach);


--
-- Name: users_created_by_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX users_created_by_index ON public.users USING btree (created_by);


--
-- Name: users_profilable_type_profilable_id_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX users_profilable_type_profilable_id_index ON public.users USING btree (profilable_type, profilable_id);


--
-- Name: users_userable_type_userable_id_index; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX users_userable_type_userable_id_index ON public.users USING btree (userable_type, userable_id);


--
-- Name: users_username_type_of_account_phone_number_email_status_can_be; Type: INDEX; Schema: public; Owner: master_db_admin
--

CREATE INDEX users_username_type_of_account_phone_number_email_status_can_be ON public.users USING btree (username, type_of_account, phone_number, email, status, can_be_delete);


--
-- Name: articles articles_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: balance_des_comptes balance_des_comptes_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.balance_des_comptes
    ADD CONSTRAINT balance_des_comptes_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: balance_des_comptes balance_des_comptes_exercice_comptable_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.balance_des_comptes
    ADD CONSTRAINT balance_des_comptes_exercice_comptable_id_foreign FOREIGN KEY (exercice_comptable_id) REFERENCES public.exercices_comptable(id) ON DELETE CASCADE;


--
-- Name: categories_de_compte categories_de_compte_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.categories_de_compte
    ADD CONSTRAINT categories_de_compte_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: categories_of_employees categories_of_employees_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.categories_of_employees
    ADD CONSTRAINT categories_of_employees_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories_of_employees(id) ON DELETE CASCADE;


--
-- Name: categories_of_employees categories_of_employees_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.categories_of_employees
    ADD CONSTRAINT categories_of_employees_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: category_of_employee_taux category_of_employee_taux_category_of_employee_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.category_of_employee_taux
    ADD CONSTRAINT category_of_employee_taux_category_of_employee_id_foreign FOREIGN KEY (category_of_employee_id) REFERENCES public.categories_of_employees(id) ON DELETE CASCADE;


--
-- Name: category_of_employee_taux category_of_employee_taux_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.category_of_employee_taux
    ADD CONSTRAINT category_of_employee_taux_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: category_of_employee_taux category_of_employee_taux_taux_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.category_of_employee_taux
    ADD CONSTRAINT category_of_employee_taux_taux_id_foreign FOREIGN KEY (taux_id) REFERENCES public.taux_and_salaries(id) ON DELETE CASCADE;


--
-- Name: classes_de_compte classes_de_compte_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.classes_de_compte
    ADD CONSTRAINT classes_de_compte_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: companies companies_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: comptes comptes_categorie_de_compte_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.comptes
    ADD CONSTRAINT comptes_categorie_de_compte_id_foreign FOREIGN KEY (categorie_de_compte_id) REFERENCES public.categories_de_compte(id) ON DELETE CASCADE;


--
-- Name: comptes comptes_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.comptes
    ADD CONSTRAINT comptes_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: contracts contracts_contract_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.contracts
    ADD CONSTRAINT contracts_contract_id_foreign FOREIGN KEY (contract_id) REFERENCES public.contracts(id) ON DELETE CASCADE;


--
-- Name: contracts contracts_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.contracts
    ADD CONSTRAINT contracts_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: contracts contracts_employee_contractuel_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.contracts
    ADD CONSTRAINT contracts_employee_contractuel_id_foreign FOREIGN KEY (employee_contractuel_id) REFERENCES public.employee_contractuels(id) ON DELETE CASCADE;


--
-- Name: contracts contracts_poste_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.contracts
    ADD CONSTRAINT contracts_poste_id_foreign FOREIGN KEY (poste_id) REFERENCES public.postes(id) ON DELETE CASCADE;


--
-- Name: contracts contracts_unite_mesures_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.contracts
    ADD CONSTRAINT contracts_unite_mesures_id_foreign FOREIGN KEY (unite_mesures_id) REFERENCES public.unite_mesures(id) ON DELETE CASCADE;


--
-- Name: contractuelables contractuelables_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.contractuelables
    ADD CONSTRAINT contractuelables_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: contractuelables contractuelables_employee_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.contractuelables
    ADD CONSTRAINT contractuelables_employee_id_foreign FOREIGN KEY (employee_id) REFERENCES public.employees(id) ON DELETE CASCADE;


--
-- Name: credentials credentials_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.credentials
    ADD CONSTRAINT credentials_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: credentials credentials_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.credentials
    ADD CONSTRAINT credentials_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: departements departements_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.departements
    ADD CONSTRAINT departements_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: devises devises_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.devises
    ADD CONSTRAINT devises_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: ecritures_comptable ecritures_comptable_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.ecritures_comptable
    ADD CONSTRAINT ecritures_comptable_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: ecritures_comptable ecritures_comptable_journal_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.ecritures_comptable
    ADD CONSTRAINT ecritures_comptable_journal_id_foreign FOREIGN KEY (journal_id) REFERENCES public.journaux(id) ON DELETE CASCADE;


--
-- Name: ecritures_comptable ecritures_comptable_operation_disponible_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.ecritures_comptable
    ADD CONSTRAINT ecritures_comptable_operation_disponible_id_foreign FOREIGN KEY (operation_disponible_id) REFERENCES public.operations_comptable(id) ON DELETE CASCADE;


--
-- Name: employee_contractuels employee_contractuels_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.employee_contractuels
    ADD CONSTRAINT employee_contractuels_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: employee_non_contractuels employee_non_contractuels_categories_of_employee_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.employee_non_contractuels
    ADD CONSTRAINT employee_non_contractuels_categories_of_employee_id_foreign FOREIGN KEY (categories_of_employee_id) REFERENCES public.categories_of_employees(id) ON DELETE CASCADE;


--
-- Name: employee_non_contractuels employee_non_contractuels_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.employee_non_contractuels
    ADD CONSTRAINT employee_non_contractuels_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: employees employees_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: exercices_comptable exercices_comptable_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.exercices_comptable
    ADD CONSTRAINT exercices_comptable_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: exercices_comptable exercices_comptable_periode_exercice_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.exercices_comptable
    ADD CONSTRAINT exercices_comptable_periode_exercice_id_foreign FOREIGN KEY (periode_exercice_id) REFERENCES public.periodes_exercice(id) ON DELETE CASCADE;


--
-- Name: exercices_comptable exercices_comptable_plan_comptable_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.exercices_comptable
    ADD CONSTRAINT exercices_comptable_plan_comptable_id_foreign FOREIGN KEY (plan_comptable_id) REFERENCES public.plans_comptable(id) ON DELETE CASCADE;


--
-- Name: journaux journaux_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.journaux
    ADD CONSTRAINT journaux_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: journaux journaux_exercice_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.journaux
    ADD CONSTRAINT journaux_exercice_id_foreign FOREIGN KEY (exercice_id) REFERENCES public.exercices_comptable(id) ON DELETE CASCADE;


--
-- Name: lignes_ecriture_comptable lignes_ecriture_comptable_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.lignes_ecriture_comptable
    ADD CONSTRAINT lignes_ecriture_comptable_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: montants montants_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.montants
    ADD CONSTRAINT montants_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: non_contractuel_categories non_contractuel_categories_categories_of_employee_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.non_contractuel_categories
    ADD CONSTRAINT non_contractuel_categories_categories_of_employee_id_foreign FOREIGN KEY (categories_of_employee_id) REFERENCES public.categories_of_employees(id) ON DELETE CASCADE;


--
-- Name: non_contractuel_categories non_contractuel_categories_category_of_employee_taux_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.non_contractuel_categories
    ADD CONSTRAINT non_contractuel_categories_category_of_employee_taux_id_foreign FOREIGN KEY (category_of_employee_taux_id) REFERENCES public.category_of_employee_taux(id) ON DELETE CASCADE;


--
-- Name: non_contractuel_categories non_contractuel_categories_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.non_contractuel_categories
    ADD CONSTRAINT non_contractuel_categories_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: non_contractuel_categories non_contractuel_categories_employee_non_contractuel_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.non_contractuel_categories
    ADD CONSTRAINT non_contractuel_categories_employee_non_contractuel_id_foreign FOREIGN KEY (employee_non_contractuel_id) REFERENCES public.employee_non_contractuels(id) ON DELETE CASCADE;


--
-- Name: operations_comptable operations_comptable_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.operations_comptable
    ADD CONSTRAINT operations_comptable_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: people people_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.people
    ADD CONSTRAINT people_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: periodes_exercice periodes_exercice_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.periodes_exercice
    ADD CONSTRAINT periodes_exercice_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: plan_comptable_compte_sous_comptes plan_comptable_compte_sous_comptes_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_compte_sous_comptes
    ADD CONSTRAINT plan_comptable_compte_sous_comptes_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: plan_comptable_compte_sous_comptes plan_comptable_compte_sous_comptes_account_id_for; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_compte_sous_comptes
    ADD CONSTRAINT plan_comptable_compte_sous_comptes_account_id_for FOREIGN KEY (account_id) REFERENCES public.plan_comptable_comptes(id) ON DELETE CASCADE;


--
-- Name: plan_comptable_compte_sous_comptes plan_comptable_compte_sous_comptes_sous_compte_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_compte_sous_comptes
    ADD CONSTRAINT plan_comptable_compte_sous_comptes_sous_compte_id_foreign FOREIGN KEY (sous_compte_id) REFERENCES public.comptes(id) ON DELETE CASCADE;


--
-- Name: plan_comptable_compte_sous_comptes plan_comptable_compte_sous_comptes_sub_division_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_compte_sous_comptes
    ADD CONSTRAINT plan_comptable_compte_sous_comptes_sub_division_id_foreign FOREIGN KEY (sub_division_id) REFERENCES public.comptes(id) ON DELETE CASCADE;


--
-- Name: plan_comptable_comptes plan_comptable_comptes_classe_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_comptes
    ADD CONSTRAINT plan_comptable_comptes_classe_id_foreign FOREIGN KEY (classe_id) REFERENCES public.classes_de_compte(id) ON DELETE CASCADE;


--
-- Name: plan_comptable_comptes plan_comptable_comptes_compte_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_comptes
    ADD CONSTRAINT plan_comptable_comptes_compte_id_foreign FOREIGN KEY (compte_id) REFERENCES public.comptes(id) ON DELETE CASCADE;


--
-- Name: plan_comptable_comptes plan_comptable_comptes_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_comptes
    ADD CONSTRAINT plan_comptable_comptes_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: plan_comptable_comptes plan_comptable_comptes_plan_comptable_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plan_comptable_comptes
    ADD CONSTRAINT plan_comptable_comptes_plan_comptable_id_foreign FOREIGN KEY (plan_comptable_id) REFERENCES public.plans_comptable(id) ON DELETE CASCADE;


--
-- Name: plans_comptable plans_comptable_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.plans_comptable
    ADD CONSTRAINT plans_comptable_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: poste_salaries poste_salaries_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.poste_salaries
    ADD CONSTRAINT poste_salaries_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: poste_salaries poste_salaries_poste_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.poste_salaries
    ADD CONSTRAINT poste_salaries_poste_id_foreign FOREIGN KEY (poste_id) REFERENCES public.postes(id) ON DELETE CASCADE;


--
-- Name: poste_salaries poste_salaries_salary_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.poste_salaries
    ADD CONSTRAINT poste_salaries_salary_id_foreign FOREIGN KEY (salary_id) REFERENCES public.taux_and_salaries(id) ON DELETE CASCADE;


--
-- Name: postes postes_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.postes
    ADD CONSTRAINT postes_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: postes postes_department_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.postes
    ADD CONSTRAINT postes_department_id_foreign FOREIGN KEY (department_id) REFERENCES public.departements(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: roles roles_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: salaires salaires_contract_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.salaires
    ADD CONSTRAINT salaires_contract_id_foreign FOREIGN KEY (contract_id) REFERENCES public.contracts(id) ON DELETE CASCADE;


--
-- Name: salaires salaires_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.salaires
    ADD CONSTRAINT salaires_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: salaires salaires_poste_salarie_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.salaires
    ADD CONSTRAINT salaires_poste_salarie_id_foreign FOREIGN KEY (poste_salarie_id) REFERENCES public.poste_salaries(id) ON DELETE CASCADE;


--
-- Name: taux_and_salaries taux_and_salaries_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.taux_and_salaries
    ADD CONSTRAINT taux_and_salaries_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: taux_and_salaries taux_and_salaries_montant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.taux_and_salaries
    ADD CONSTRAINT taux_and_salaries_montant_id_foreign FOREIGN KEY (montant_id) REFERENCES public.montants(id) ON DELETE CASCADE;


--
-- Name: taux_and_salaries taux_and_salaries_unite_mesure_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.taux_and_salaries
    ADD CONSTRAINT taux_and_salaries_unite_mesure_id_foreign FOREIGN KEY (unite_mesure_id) REFERENCES public.unite_mesures(id) ON DELETE CASCADE;


--
-- Name: taux_and_salaries taux_and_salaries_unite_travaille_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.taux_and_salaries
    ADD CONSTRAINT taux_and_salaries_unite_travaille_id_foreign FOREIGN KEY (unite_travaille_id) REFERENCES public.unite_travailles(id) ON DELETE CASCADE;


--
-- Name: unite_mesures unite_mesures_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.unite_mesures
    ADD CONSTRAINT unite_mesures_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: unite_travailles unite_travailles_article_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.unite_travailles
    ADD CONSTRAINT unite_travailles_article_id_foreign FOREIGN KEY (article_id) REFERENCES public.articles(id) ON DELETE CASCADE;


--
-- Name: unite_travailles unite_travailles_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.unite_travailles
    ADD CONSTRAINT unite_travailles_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: unite_travailles unite_travailles_unite_mesure_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.unite_travailles
    ADD CONSTRAINT unite_travailles_unite_mesure_id_foreign FOREIGN KEY (unite_mesure_id) REFERENCES public.unite_mesures(id) ON DELETE CASCADE;


--
-- Name: user_has_roles user_has_roles_attached_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.user_has_roles
    ADD CONSTRAINT user_has_roles_attached_by_foreign FOREIGN KEY (attached_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: user_has_roles user_has_roles_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.user_has_roles
    ADD CONSTRAINT user_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: user_has_roles user_has_roles_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.user_has_roles
    ADD CONSTRAINT user_has_roles_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: users users_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: master_db_admin
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

