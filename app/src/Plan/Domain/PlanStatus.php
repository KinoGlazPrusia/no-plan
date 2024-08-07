<?php
namespace App\Plan\Domain;

/* Value Object */
/* Este value object se inicializa con el valor de una de las constantes de la clase PlanStatus
Con lo que la propia clase ya contiene todos los valores posibles
Por ejemplo: new PlanStatus(PlanStatus::DRAFT)  */
class PlanStatus {
    const DRAFT = 'draft';
    const PUBLISHED = 'published';
}